#!/bin/bash

# Verificar que se haya pasado un parámetro
if [ $# -eq 0 ]; then
    echo "Uso: $0 <id_pago>"
    exit 1
fi

# Capturar el parámetro
id_pago=$1

# Ruta al ejecutable de Python
python_exec_path="C:\Users\Hp\AppData\Local\Programs\Python\Python311\python"

# Ruta al script de Python
python_script_path="/c/xampp/htdocs/sistema_satelite2/ticket_pago.py"

# Ejecutar el script de Python y pasar el parámetro (id_pago)
output=$( "$python_exec_path" "$python_script_path" "$id_pago" 2>&1 )

# Capturar el código de retorno
return_code=$?

# Mostrar la salida

echo "$output"

# Retornar el código de retorno del script de Python
exit $return_code
