#!/bin/bash
set -e

echo "🔧 Setting up permissions..."

# Criar diretório var se não existir
mkdir -p /var/www/html/var

# Garantir permissões do diretório var
chown -R www-data:www-data /var/www/html/var
chmod -R 775 /var/www/html/var

# Criar banco se não existir
if [ ! -f "/var/www/html/var/data_prod.db" ]; then
    echo "📦 Creating database..."
    touch /var/www/html/var/data_prod.db
    chown www-data:www-data /var/www/html/var/data_prod.db
    chmod 664 /var/www/html/var/data_prod.db
    su www-data -s /bin/bash -c "php bin/console doctrine:schema:create --env=prod" || true
else
    echo "📦 Database exists, ensuring permissions..."
    chown www-data:www-data /var/www/html/var/data_prod.db
    chmod 664 /var/www/html/var/data_prod.db
fi

echo "✅ Setup complete, starting PHP-FPM..."

exec "$@"