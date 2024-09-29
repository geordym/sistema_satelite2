
<?php
namespace App\Services; // Asegúrate de tener el namespace correcto
use FPDF;
use Illuminate\Support\Facades\Http;

class TicketPago
{
    //
    public function generateTicketPDF($idPago)
    {
        // Definir la URL del endpoint
        $url = "http://localhost/sistema_satelite2/public/api/pagos/info-download/{$idPago}";

        // Hacer la solicitud GET al endpoint
        $response = Http::get($url);

        if ($response->successful()) {
            // Obtener los datos del JSON
            $data = $response->json();

            // Crear un nuevo documento PDF
            $pdf = new FPDF();
            $pdf->AddPage('P', 'A6'); // Añadir una página en modo Portrait y tamaño A6
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(0, 10, 'TICKET DE PAGO', 0, 1, 'C'); // Título centrado

            // Configurar la fuente para el contenido
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 10, "ID Pago: {$data['id']}", 0, 1);
            $pdf->Cell(0, 10, "Operador: {$data['operador']['nombre']}", 0, 1);
            $pdf->Cell(0, 10, "Método de Pago: {$data['metodo_pago']}", 0, 1);
            $pdf->Cell(0, 10, "Total: $" . number_format($data['total'], 2), 0, 1);
            $pdf->Cell(0, 10, "Fecha: " . date('Y-m-d', strtotime($data['created_at'])), 0, 1);
            $pdf->Cell(0, 10, str_repeat('-', 35), 0, 1); // Separador

            // Título de procesos
            $pdf->Cell(0, 10, "PROCESOS:", 0, 1);

            // Imprimir procesos
            foreach ($data['pago_procesos'] as $proceso) {
                $pdf->Cell(0, 10, "Proceso ID: {$proceso['id']}", 0, 1);
                $pdf->Cell(0, 10, "Actividad: {$proceso['actividad']}", 0, 1);
                $pdf->Cell(0, 10, "Cantidad: {$proceso['cantidad']}", 0, 1);
                $pdf->Cell(0, 10, "Total: $" . number_format($proceso['total'], 2), 0, 1);
                $pdf->Cell(0, 10, str_repeat('-', 35), 0, 1); // Separador
            }

            // Generar el nombre del archivo PDF
            $pdfFileName = "ticket_pago_{$idPago}.pdf";
            $pdf->Output('D', $pdfFileName); // Forzar la descarga del archivo PDF
        } else {
            return response()->json(['error' => 'Error al obtener los datos: ' . $response->status()], 500);
        }
    }

}
