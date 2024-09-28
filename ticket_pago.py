import argparse
import requests
import json
from fpdf import FPDF
import matplotlib.pyplot as plt
from io import BytesIO
import os  # Para obtener la ruta actual del script
import tempfile  # Para crear un archivo temporal

# Definir la URL base de la API
API_URL = "http://192.168.200.107:8050"  # Cambia esto por tu URL real

def get_report(year, month):
    endpoint_report_payment = f"{API_URL}/api/reportes/ingresos/{year}/{month}"

    try:
        response = requests.get(endpoint_report_payment)

        if response.status_code == 200:
            payments = response.json()
            return payments
        else:
            print(f"Error: No se pudo obtener los pagos. Código de respuesta: {response.status_code}")
            return []
    
    except requests.exceptions.RequestException as e:
        print(f"Error en la petición: {e}")
        return []

def generate_bar_chart(payments, year, month):
    # Obtener el número total de días en el mes
    from calendar import monthrange
    num_days = monthrange(year, month)[1]  # Obtiene el número de días en el mes

    # Inicializar el diccionario con todos los días del mes y valor 0
    daily_income = {day: 0 for day in range(1, num_days + 1)}

    # Organizar los ingresos por día del mes
    for payment in payments:
        date = payment['fecha']  # Asumimos que la fecha tiene el formato 'YYYY-MM-DD'
        day = int(date.split('-')[2])  # Obtener el día
        daily_income[day] += payment['monto']

    # Ordenar los días y los ingresos
    days = sorted(daily_income.keys())
    incomes = [daily_income[day] for day in days]

    # Crear el gráfico de barras
    plt.figure(figsize=(12, 6))
    plt.bar(days, incomes, color='blue')
    plt.xlabel('Día del mes')
    plt.ylabel('Ingresos')
    plt.title(f'Ingresos por día - {year}/{month}')

    # Guardar el gráfico en un archivo temporal
    temp_image = tempfile.NamedTemporaryFile(delete=False, suffix=".png")
    plt.savefig(temp_image.name, format='png')
    plt.close()

    return temp_image.name  # Retornar la ruta del archivo temporal

def generate_pdf(payments, year, month):
    # Obtener la ruta actual del script
    current_dir = os.getcwd()

    # Crear el PDF
    pdf = FPDF()
    pdf.add_page()

    # Título del PDF
    pdf.set_font("Arial", size=16, style='B')
    pdf.cell(200, 10, f'Reporte de Ingresos - {year}/{month}', ln=True, align='C')

    # Espacio
    pdf.ln(10)

    # Lista de pagos
    pdf.set_font("Arial", size=12)
    for payment in payments:
        pdf.cell(200, 10, f"ID: {payment['id']}, Monto: {payment['monto']}, Fecha: {payment['fecha']}", ln=True)

    # Insertar el gráfico de barras en el PDF
    pdf.ln(10)
    pdf.set_font("Arial", size=14, style='B')
    pdf.cell(200, 10, "Gráfico de Ingresos por Día", ln=True, align='C')
    pdf.ln(10)

    # Generar el gráfico de barras y guardar en un archivo temporal
    chart_path = generate_bar_chart(payments, year, month)

    # Agregar el gráfico al PDF
    pdf.image(chart_path, x=10, y=None, w=180)

    # Guardar el PDF en la misma ruta donde está el script
    output_filename = os.path.join(current_dir, f"reporte_ingresos_{year}_{month}.pdf")
    pdf.output(output_filename)
    print(f"PDF generado: {output_filename}")

    # Eliminar el archivo temporal
    os.remove(chart_path)

if __name__ == "__main__":
    # Crear el parser de argumentos
    parser = argparse.ArgumentParser(description="Obtener reporte de pagos por año y mes y generar un PDF.")
    
    # Añadir los argumentos de año y mes
    parser.add_argument("year", type=int, help="El año del reporte (ej: 2024)")
    parser.add_argument("month", type=int, help="El mes del reporte (ej: 9)")

    # Parsear los argumentos
    args = parser.parse_args()

    # Obtener el reporte de pagos
    payments = get_report(args.year, args.month)

    # Generar el PDF con la lista de pagos y el gráfico de barras
    if payments:
        generate_pdf(payments, args.year, args.month)
    else:
        print("No hay pagos para generar el reporte.")
