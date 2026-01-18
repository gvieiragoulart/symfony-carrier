#!/bin/bash
set -e

# Garantir permissões do diretório var
chown -R www-data:www-data /var/www/html/var
chmod -R 775 /var/www/html/var

# Criar banco se não existir
if [ ! -f "/var/www/html/var/data_prod.db" ]; then
    echo "📦 Creating database..."
    su www-data -s /bin/bash -c "php bin/console doctrine:schema:create --env=prod" || true
fi

exec "$@"