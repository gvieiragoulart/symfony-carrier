FROM php:8.4-fpm AS base

# Instalar dependências do sistema (incluindo SQLite)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libsqlite3-dev \
    && docker-php-ext-install \
    pdo \
    pdo_sqlite \
    zip \
    intl \
    opcache \
    && rm -rf /var/lib/apt/lists/*

# Configurações do PHP para produção
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# ----------------------------
# Stage: Produção
# ----------------------------
FROM base AS production

# Copiar apenas arquivos necessários para instalar dependências
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copiar código fonte
COPY --chown=www-data:www-data . .

# Criar diretórios necessários e ajustar permissões
RUN mkdir -p /var/www/html/var/data \
    /var/www/html/var/cache \
    /var/www/html/var/log \
    && chown -R www-data:www-data /var/www/html/var \
    && chmod -R 775 /var/www/html/var

# Executar scripts e gerar cache como www-data
USER www-data
RUN composer run-script post-install-cmd --no-dev || true \
    && php bin/console cache:warmup --env=prod

# Voltar para root para o entrypoint
USER root

# Script de inicialização
COPY --chmod=755 docker/entrypoint.sh /usr/local/bin/entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]