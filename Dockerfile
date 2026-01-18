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

# Copiar apenas arquivos necessários
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

COPY . .

# Criar diretório para o SQLite e dar permissões
RUN mkdir -p /var/www/html/var/data \
    && chown -R www-data:www-data /var/www/html/var \
    && chmod -R 775 /var/www/html/var

# Executar scripts e limpar cache
RUN composer run-script post-install-cmd --no-dev || true \
    && php bin/console cache:warmup --env=prod

EXPOSE 9000

CMD ["php-fpm"]