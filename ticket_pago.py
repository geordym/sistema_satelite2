import requests
from reportlab.lib.pagesizes import A6  # Tamaño de papel A6
from reportlab.lib.units import mm
from reportlab.pdfgen import canvas
import os
import tempfile
import uuid  # Importar el módulo uuid
from flask import Flask, jsonify, request

app = Flask(__name__)

def generar_ticket(id_pago):
    # Definir la URL del endpoint
    url = f'http://localhost/sistema_satelite2/public/api/pagos/info-download/{id_pago}'
    
    # Hacer la solicitud GET al endpoint
    response = requests.get(url)
    
    if response.status_code == 200:
        # Obtener los datos del JSON
        data = response.json()
        
        # Crear un archivo PDF en la carpeta temporal
        temp_dir = tempfile.gettempdir()
        pdf_path = os.path.join(temp_dir, f'ticket_pago_{uuid.uuid4()}.pdf')  # Nombre aleatorio
        
        # Crear un canvas temporal para calcular la altura necesaria
        temp_canvas = canvas.Canvas(pdf_path, pagesize=(58 * mm, 0))  # Inicialmente sin altura definida
        temp_canvas.setFont("Helvetica", 10)

        # Calcular la altura necesaria en función del contenido
        line_height = 6 * mm
        y_position = 0

        # Espacios para la información principal
        y_position += 5 * line_height  # Espacio para ID Pago
        y_position += line_height  # Espacio para Operador
        y_position += line_height  # Espacio para Método de Pago
        y_position += line_height  # Espacio para Total
        y_position += line_height  # Espacio para Fecha
        y_position += line_height  # Espacio para Separador
        y_position += line_height  # Espacio para "PROCESOS"

        # Imprimir procesos
        for proceso in data['pago_procesos']:
            y_position += line_height  # Espacio para Proceso ID
            y_position += line_height  # Espacio para Cantidad
            y_position += line_height  # Espacio para Descripción
            y_position += line_height  # Espacio para Valor Actividad
            y_position += line_height  # Espacio para Total del Proceso
            y_position += 10 * mm  # Espacio adicional entre procesos

        # Definir la altura total del PDF
        total_height = max(y_position, 100 * mm)  # Asegurar que sea al menos 100 mm de altura
        
        # Crear el PDF final con la altura calculada
        c = canvas.Canvas(pdf_path, pagesize=(58 * mm, total_height))  # Establecer la altura calculada
        c.setFont("Helvetica", 10)

        # Dibujar un borde más pequeño
        border_margin = 2 * mm  # Reducir el borde
        c.rect(border_margin, border_margin, 58 * mm - 2 * border_margin, total_height - 2 * border_margin)  # (x, y, width, height)

        # Título
        c.setFont("Helvetica-Bold", 12)
        c.drawString(10 * mm, total_height - 10 * mm, "TICKET DE PAGO")
        
        # Imprimir los datos en el PDF
        c.setFont("Helvetica", 10)
        y_position = total_height - 15 * mm  # Ajustar la posición Y para el texto

        # ID Pago
        c.drawString(10 * mm, y_position, "ID Pago:")
        c.drawString(25 * mm, y_position, str(data['id']))
        y_position -= line_height  # Salto de línea

        # Operador
        c.setFont("Helvetica", 10)  
        c.drawString(10 * mm, y_position, "Operador:")
        y_position -= line_height  # Salto de línea
        c.setFont("Helvetica", 8)  
        c.drawString(10 * mm, y_position, data['operador']['nombre'])
        y_position -= line_height  # Espacio adicional

        # Método de Pago
        c.setFont("Helvetica", 10)  
        c.drawString(10 * mm, y_position, "Método de Pago:")
        y_position -= line_height  # Salto de línea
        
        c.setFont("Helvetica", 8)  
        c.drawString(10 * mm, y_position, data['metodo_pago'])
        y_position -= line_height  # Espacio adicional

        # Total
        c.setFont("Helvetica", 10)  
        c.drawString(10 * mm, y_position, "Total:")
        y_position -= line_height  # Salto de línea
        
        c.setFont("Helvetica", 8)  
        c.drawString(10 * mm, y_position, f"${data['total']}")
        y_position -= line_height  # Espacio adicional

        # Fecha
        c.drawString(10 * mm, y_position, "Fecha:")
        y_position -= line_height  # Salto de línea
        c.drawString(10 * mm, y_position, data['created_at'].split("T")[0])  # Solo la fecha
        y_position -= line_height  # Espacio adicional

        # Separador
        c.drawString(10 * mm, y_position, "-" * 35)  # Separador
        y_position -= 5 * mm  # Espacio adicional

        # Título de procesos
        c.drawString(10 * mm, y_position, "PROCESOS:")
        y_position -= line_height  # Salto de línea
        
        # Cambiar estilos para procesos 
        c.setFont("Helvetica", 8)  # Ajustar el tamaño de fuente si es necesario

        # Imprimir procesos
        for proceso in data['pago_procesos']:
            c.drawString(10 * mm, y_position, f"Proceso ID: {proceso['id']}")
            y_position -= line_height  # Salto de línea
            c.drawString(10 * mm, y_position, f"Actividad: {proceso['actividad']}")
            y_position -= line_height  # Salto de línea
            c.drawString(10 * mm, y_position, f"Cantidad: {proceso['cantidad']}")
            y_position -= line_height  # Salto de línea
            c.drawString(10 * mm, y_position, f"Total: ${proceso['total']}")
            y_position -= 2 * line_height  # Espaciado entre procesos
            
            c.drawString(10 * mm, y_position + 20, "-" * 35)  # Separador
            y_position -= 2 * mm  # Espacio adicional

        # Finalizar el PDF
        c.save()
        
        # Retornar la ruta del PDF generado
        return pdf_path
    else:
        print("Error al obtener los datos:", response.status_code)
        return None

# Endpoint para generar el ticket
@app.route('/api/generar_ticket', methods=['POST'])
def crear_ticket():
    data = request.json
    id_pago = data.get('id_pago')

    if not id_pago:
        return jsonify({"error": "ID de pago es requerido"}), 400
    
    pdf_path = generar_ticket(id_pago)

    if pdf_path:
        return jsonify({"pdf_path": pdf_path}), 200
    else:
        return jsonify({"error": "No se pudo generar el ticket"}), 500

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
