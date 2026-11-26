#!/usr/bin/env bash
# SportVibes — Actualización del código en el VPS desde GitHub.
# Uso: sudo bash /var/www/sportvibes/deploy/deploy.sh

set -euo pipefail

RUTA="${RUTA_PROYECTO:-/var/www/sportvibes}"
RAMA="${RAMA_DESPLIEGUE:-main}"

echo "==> SportVibes: actualizando desde GitHub (rama ${RAMA})"
cd "$RUTA"

# --ff-only evita sobrescribir cambios locales accidentales en el VPS.
git fetch origin "$RAMA"
git pull --ff-only origin "$RAMA"

if [[ ! -f "$RUTA/.env" ]]; then
  echo "ERROR: no existe $RUTA/.env. Copia .env.example y ajusta los valores antes de desplegar." >&2
  exit 1
fi

echo "==> Ajustando permisos de subidas"
find "$RUTA/public/uploads" -type d -exec chmod 775 {} +
find "$RUTA/public/uploads" -type f -exec chmod 664 {} +

# El directorio .git y .env no deben ser legibles por el servidor web.
chmod -R o-rwx "$RUTA/.git" 2>/dev/null || true
chmod 640 "$RUTA/.env"

echo "==> Recargando Nginx"
if command -v nginx >/dev/null 2>&1; then
  nginx -t && systemctl reload nginx
else
  echo "Aviso: nginx no encontrado; omitir recarga manual si usas otro servidor."
fi

echo "==> Despliegue completado: $(date '+%Y-%m-%d %H:%M:%S')"
