#!/bin/bash

# Configuración de MySQL
USER="root"
PASSWORD=""  # Cambia si tienes contraseña
HOST="localhost"

# Archivo que contiene los nombres de las bases de datos clonadas
CLONE_DB_FILE="databases_clones.txt"

# Verificar si el archivo existe
if [ ! -f "$CLONE_DB_FILE" ]; then
    echo "El archivo '$CLONE_DB_FILE' no existe."
    exit 1
fi

# Leer el archivo y eliminar cada base de datos
while IFS= read -r DB_NAME; do
    # Verificar que el nombre de la base de datos no esté vacío
    if [ -z "$DB_NAME" ]; then
        continue
    fi

    echo "Eliminando la base de datos '$DB_NAME'..."
    
    # Comando para eliminar la base de datos
    "C:/xampp/mysql/bin/mysql" -u $USER -h $HOST -e "DROP DATABASE $DB_NAME;"

    # Verificar si la eliminación fue exitosa
    if [ $? -eq 0 ]; then
        echo "Base de datos '$DB_NAME' eliminada exitosamente."
    else
        echo "Error al eliminar la base de datos '$DB_NAME'."
    fi
done < "$CLONE_DB_FILE"

echo "Proceso de eliminación completado."
