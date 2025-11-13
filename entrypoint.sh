#!/usr/bin/env bash
set -e

PORT="${PORT:-10000}"

echo "Configuring Apache to listen on port ${PORT}..."
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf || true
sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/" /etc/apache2/sites-available/000-default.conf || true

# Mostrar los archivos de configuración para depuración
echo "ports.conf:"
grep -n "Listen" /etc/apache2/ports.conf || true
echo "000-default.conf:"
grep -n "<VirtualHost" /etc/apache2/sites-available/000-default.conf || true

exec apache2-foreground