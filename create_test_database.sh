#!/bin/bash

# Configuración de MySQL
USER="root"               
PASSWORD=""           
HOST="localhost"        
PROD_DB="sistema_satelite2"    

# Generar un nombre aleatorio para la nueva base de datos
NEW_DB="clon_$(date +%s)_$RANDOM"

# Crear un dump de la base de datos de producción
echo "Creando dump de la base de datos de producción..."
mysqldump -u $USER -p$PASSWORD -h $HOST $PROD_DB > dump_produccion.sql

# Verificar si el dump fue creado con éxito
if [ $? -eq 0 ]; then
    echo "Dump creado exitosamente."
else
    echo "Error al crear el dump. Saliendo..."
    exit 1
fi

# Crear la nueva base de datos
echo "Creando la nueva base de datos '$NEW_DB'..."
mysql -u $USER -p$PASSWORD -h $HOST -e "CREATE DATABASE $NEW_DB;"

# Verificar si la base de datos fue creada exitosamente
if [ $? -eq 0 ]; then
    echo "Base de datos '$NEW_DB' creada exitosamente."
else
    echo "Error al crear la nueva base de datos. Saliendo..."
    exit 1
fi

# Restaurar el dump en la nueva base de datos
echo "Restaurando dump en la nueva base de datos '$NEW_DB'..."
mysql -u $USER -p$PASSWORD -h $HOST $NEW_DB < dump_produccion.sql

# Verificar si la restauración fue exitosa
if [ $? -eq 0 ]; then
    echo "Dump restaurado exitosamente en la base de datos '$NEW_DB'."
else
    echo "Error al restaurar el dump. Saliendo..."
    exit 1
fi

# Borrar el archivo de dump para limpiar
rm dump_produccion.sql

# Retornar el nombre de la nueva base de datos
echo "La nueva base de datos es: $NEW_DB"
