#!/bin/sh
set -eu

PORT="${PORT:-10000}"
case "$PORT" in
  ''|*[!0-9]*) echo "PORT deve conter apenas números." >&2; exit 1 ;;
esac

if [ "$PORT" != "80" ]; then
  sed -ri "s/^Listen 80$/Listen ${PORT}/" /etc/apache2/ports.conf
  sed -ri "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf
fi

exec "$@"
