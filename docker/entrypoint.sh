#!/usr/bin/env sh
set -e

# Ensure Laravel runtime directories always exist on mounted host volume.
mkdir -p bootstrap/cache \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs

# Try preferred ownership/perms for php-fpm worker (www-data).
chown -R www-data:www-data bootstrap/cache storage || true
chmod -R ug+rwX bootstrap/cache storage || true

# WSL bind-mounts can ignore ownership changes; ensure php-fpm worker can always write.
chmod -R 777 \
    bootstrap/cache \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs || true

# Passport keys are sometimes generated as root with restrictive perms (600),
# which makes them unreadable by php-fpm worker (www-data) on bind mounts.
if [ -f storage/oauth-private.key ] || [ -f storage/oauth-public.key ]; then
    chown www-data:www-data storage/oauth-private.key storage/oauth-public.key 2>/dev/null || true
    chmod 660 storage/oauth-private.key storage/oauth-public.key 2>/dev/null || true
fi

if [ ! -f .env ]; then
    cp .env.example .env
fi

if [ ! -f vendor/autoload.php ]; then
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

if ! grep -q '^APP_KEY=base64:' .env; then
    php artisan key:generate --force --ansi
fi

exec "$@"
