#!/bin/bash

# Configuración de MySQL
USER="root"              
PASSWORD=""          
HOST="localhost"         
DATABASE="sistema_satelite2" 

# Ruta donde almacenarás los respaldos (usando / en lugar de \)
BACKUP_DIR="/c/Users/Hp/Documents/Sistema Satelite Backup"

# Fecha actual para incluir en el nombre del archivo
DATE=$(date +"%Y%m%d_%H%M%S")

# Nombre del archivo de respaldo
BACKUP_FILE="$BACKUP_DIR/backup_${DATABASE}_$DATE.sql"

# Crear el directorio de respaldos si no existe
mkdir -p "$BACKUP_DIR"

# Crear el respaldo usando mysqldump (ruta completa)
echo "Creando respaldo de la base de datos $DATABASE..."
"C:/xampp/mysql/bin/mysqldump" -u "$USER" -p"$PASSWORD" -h "$HOST" "$DATABASE" > "$BACKUP_FILE"

# Verificar si el respaldo se creó correctamente
if [ $? -eq 0 ]; then
    echo "Respaldo creado exitosamente: $BACKUP_FILE"
else
    echo "Error al crear el respaldo de la base de datos."
    exit 1
fi

# (Opcional) Comprimir el respaldo para ahorrar espacio
# gzip "$BACKUP_FILE"
