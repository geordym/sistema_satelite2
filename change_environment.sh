#!/bin/bash

# Función para cambiar el entorno y vaciar el caché de Laravel
switch_env() {
    local env_file=$1
    if [ -f "$env_file" ]; then
        # Copiar el contenido del archivo seleccionado a .env
        cp "$env_file" .env
        echo "El archivo .env ha sido actualizado con el entorno de $2."

        # Vaciar el caché de Laravel
        echo "Vaciando el caché de Laravel..."
        php artisan config:clear
        php artisan cache:clear
        php artisan route:clear
        php artisan view:clear
        php artisan event:clear

        echo "Caché vaciado y entorno cambiado a $2."
    else
        echo "El archivo $env_file no existe. Asegúrate de que el archivo está presente."
        exit 1
    fi
}

# Preguntar al usuario qué entorno desea
echo "¿Desea cambiar el entorno a?"
echo "1. Producción"
echo "2. Local"

read -p "Seleccione una opción (1 o 2): " option

case $option in
    1)
        # Cambiar a Producción
        switch_env ".env.production" "Producción"
        ;;
    2)
        # Cambiar a Local
        switch_env ".env.local" "Local"
        ;;
    *)
        echo "Opción no válida. Por favor, seleccione 1 o 2."
        ;;
esac
