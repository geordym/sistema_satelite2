#!/bin/bash

# Verificar si estamos en el directorio raíz de Laravel
if [ ! -f artisan ]; then
    echo "Este script debe ejecutarse desde el directorio raíz de una aplicación Laravel."
    exit 1
fi

# Limpiar caché de configuración
echo "Limpiando caché de configuración..."
php artisan config:clear

# Limpiar caché de rutas
echo "Limpiando caché de rutas..."
php artisan route:clear

# Limpiar caché de vistas
echo "Limpiando caché de vistas..."
php artisan view:clear

# Limpiar caché de aplicaciones
echo "Limpiando caché de la aplicación..."
php artisan cache:clear

# Limpiar caché de eventos (si es necesario)
echo "Limpiando caché de eventos..."
php artisan event:clear

echo "Caché de Laravel limpiado exitosamente."
