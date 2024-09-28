#!/bin/bash

# Configuración de MySQL
USER="root"               
PASSWORD=""           
HOST="localhost"        
PROD_DB="sistema_satelite2"    

# Archivo para guardar los nombres de las bases de datos clonadas
CLONE_DB_FILE="databases_clones.txt"

# Generar un nombre aleatorio para la nueva base de datos
NEW_DB="clon_$(date +%s)_$RANDOM"

# Ruta para almacenar el dump en la carpeta temporal
TEMP_DIR="/c/Users/Hp/AppData/Local/Temp"
DUMP_FILE="$TEMP_DIR/dump_produccion.sql"

# Crear un dump de la base de datos de producción
echo "Creando dump de la base de datos de producción..."
"C:/xampp/mysql/bin/mysqldump" -u $USER -h $HOST $PROD_DB > "$DUMP_FILE"

# Verificar si el dump fue creado con éxito
if [ $? -eq 0 ]; then
    echo "Dump creado exitosamente."
else
    echo "Error al crear el dump. Saliendo..."
    exit 1
fi

# Crear la nueva base de datos
echo "Creando la nueva base de datos '$NEW_DB'..."
"C:/xampp/mysql/bin/mysql" -u $USER -h $HOST -e "CREATE DATABASE $NEW_DB;"

# Verificar si la base de datos fue creada exitosamente
if [ $? -eq 0 ]; then
    echo "Base de datos '$NEW_DB' creada exitosamente."
else
    echo "Error al crear la nueva base de datos. Saliendo..."
    exit 1
fi

# Restaurar el dump en la nueva base de datos
echo "Restaurando dump en la nueva base de datos '$NEW_DB'..."
"C:/xampp/mysql/bin/mysql" -u $USER -h $HOST $NEW_DB < "$DUMP_FILE"

# Verificar si la restauración fue exitosa
if [ $? -eq 0 ]; then
    echo "Dump restaurado exitosamente en la base de datos '$NEW_DB'."
else
    echo "Error al restaurar el dump. Saliendo..."
    exit 1
fi

# Borrar el archivo de dump para limpiar
rm "$DUMP_FILE"

# Guardar el nombre de la nueva base de datos en el archivo
echo "$NEW_DB" >> "$CLONE_DB_FILE"

# Retornar el nombre de la nueva base de datos
echo "La nueva base de datos es: $NEW_DB"
