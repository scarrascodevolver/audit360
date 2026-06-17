#!/usr/bin/env bash
#
# Despliegue de audit360 por git.
# Uso (en el servidor):  cd /var/www/audit && ./deploy.sh
# Baja el código de GitHub (rama main), reconstruye el front, aplica migraciones,
# regenera cachés y reinicia el worker de la cola.
#
set -euo pipefail
cd "$(dirname "$0")"

echo "==> Bajando últimos cambios de GitHub (main)"
ANTES="$(git rev-parse HEAD)"
git fetch --quiet origin main
git reset --hard origin/main
DESPUES="$(git rev-parse HEAD)"

CAMBIOS="$(git diff --name-only "$ANTES" "$DESPUES" || true)"

if echo "$CAMBIOS" | grep -q '^composer\.lock$'; then
    echo "==> composer.lock cambió: composer install --no-dev"
    composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
fi

if echo "$CAMBIOS" | grep -qE '^package(-lock)?\.json$'; then
    echo "==> dependencias npm cambiaron: npm ci"
    npm ci
fi

echo "==> Compilando el front (npm run build)"
npm run build

echo "==> Migraciones"
php artisan migrate --force

echo "==> Regenerando cachés"
php artisan optimize
php artisan filament:optimize

echo "==> Reiniciando worker de la cola"
sudo systemctl restart audit-queue

echo "==> Deploy OK ($ANTES -> $DESPUES)"
