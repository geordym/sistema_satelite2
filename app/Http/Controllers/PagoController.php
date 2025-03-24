<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Operador;
use App\Models\Pago;
use App\Models\Proceso;
use Dompdf\Dompdf;
use Dompdf\Options;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use FPDF;
use Fpdf\Fpdf as FpdfFpdf;
use Illuminate\Support\Facades\Http;


class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $operadores = Operador::all();
        $selectedOperator = $request->input('operador_id') ?? 0;

        $pagos = Pago::all();

        return view('pagos.index')->with('operadores', $operadores)->with('pagos', $pagos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $operador_id = $request->input('operador_id');
        $operador = Operador::find($operador_id);
        $procesos_operador = $operador->procesos;
        $procesos_operador_unpayment = [];
        foreach ($procesos_operador as $proceso) {
            if ($proceso->status !== "PAGADO") {
                $procesos_operador_unpayment[] = $proceso;
            }
        }

        $actividades = Actividad::all();


        return view('pagos.create')->with('operador', $operador)->with('procesos_operador', $procesos_operador_unpayment)->with('actividades', $actividades);
    }

    public function create_payment(Request $request)
    {
        $operador_id = $request->input('operador_id');
        $procesos_ids = $request->input('selected_processes');
        $procesos_ids_array = explode(',', $procesos_ids);
        $processes_to_payment = Proceso::find($procesos_ids_array);

        $total_to_payment = 0;
        foreach ($processes_to_payment as $proccess) {
            $total_to_payment += $proccess->calcularValor();
        }

        $operador = Operador::find($operador_id);


        return view('pagos.create_payment')->with('operador', $operador)->with('operador_procesos', $processes_to_payment)->with('total_to_payment', $total_to_payment)->with('procesos_ids', $procesos_ids)
        ;
    }

    public function download_payment($id)
    {
        $endpoint_ticket = env('PRINTER_POS_API_URL', 'http://localhost:9001/api/print-ticket');

        if (!$endpoint_ticket) {
            return response()->json(['error' => 'La URL del servicio de tickets no está configurada'], 500);
        }

        $data = $this->assembleMessageToPrinter($id);

        // Convertir el array de datos en formato JSON
        $json_data = json_encode($data);

        // Escapar las comillas dobles dentro del JSON para evitar problemas con el archivo BAT
        $escaped_json_data = addslashes($json_data);

        // Crear el contenido del archivo BAT
        $bat_content = "@echo off\n";
        $bat_content .= "curl -X POST \"$endpoint_ticket\" -H \"Content-Type: application/json\" -d \"$escaped_json_data\"\n";
        $bat_content .= "pause\n";

        // Definir el nombre del archivo
        $filename = "ticket_pago_{$id}.bat";
        $filepath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $filename;

        // Guardar el archivo BAT en el servidor
        file_put_contents($filepath, $bat_content);

        // Enviar el archivo BAT como descarga y eliminarlo después de enviarlo
        return response()->download($filepath, $filename)->deleteFileAfterSend(true);
    }







    public function getPaymentData($id)
    {
        $pago = Pago::with(['operador', 'pagoProcesos'])->where('id', $id)->first();
        return json_encode($pago);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $procesos_ids = $request->input('selected_processes');
        $procesos_ids_array = explode(',', $procesos_ids);
        $processes_to_payment = Proceso::find($procesos_ids_array);

        $total_to_payment = 0;
        foreach ($processes_to_payment as $proccess) {
            $total_to_payment += $proccess->calcularValor();
        }

        $metodo_pago = $request->input('metodo_pago');
        $operador_id = $request->input('operador_id');

        // Ejecutar en una transacción
        $pago_creado = DB::transaction(function () use ($operador_id, $metodo_pago, $total_to_payment, $procesos_ids_array) {
            // Crear el nuevo pago
            $pago = new Pago();
            $pago->operador_id = $operador_id;
            $pago->metodo_pago = $metodo_pago;
            $pago->total = $total_to_payment;
            $pago->save(); // Guarda el pago en la base de datos

            // Asociar los procesos al pago
            foreach ($procesos_ids_array as $proceso_id) {
                $proceso = Proceso::find($proceso_id);
                if ($proceso->status === "PAGADO") {
                    throw new Error("No se puede pagar un proceso ya pagado");
                }

                $total_proccess = $proceso->cantidad * $proceso->actividad->valor_unitario;

                $pago->pagoProcesos()->create(
                    [
                        'pago_id' => $pago->id,
                        'proceso_id' => $proceso_id,
                        'actividad' => $proceso->actividad->nombre,
                        'descripcion' => $proceso->descripcion,
                        'fecha_procesado' => $proceso->fecha_procesado,
                        'cantidad' => $proceso->cantidad,
                        'valor_actividad' => $proceso->actividad->valor_unitario,
                        'total' => $total_proccess
                    ]
                );

                $proceso->status = "PAGADO";
                $proceso->save();
            }

            // Retornar el ID del pago creado
            return $pago->id;
        });

        $this->sendMessageToPrinter($this->assembleMessageToPrinter($pago_creado));
        $this->sendMessageToPrinter($this->assembleMessageToPrinter($pago_creado));

        return redirect()->route('admin.pagos.index')->with('success', 'Pago creado con éxito.')->with('pago_creado', $pago_creado);
    }

    public function assembleMessageToPrinter($pagoId)
    {
        // Buscar el pago por ID
        $pago = Pago::with('operador', 'pagoProcesos')->find($pagoId);

        if (!$pago) {
            return response()->json(['error' => 'Pago no encontrado'], 404);
        }

        // Construir la estructura JSON
        $jsonData = [
            "id" => $pago->id,
            "operador" => [
                "nombre" => $pago->operador->nombre
            ],
            "metodoPago" => $pago->metodo_pago,
            "total" => $pago->total,
            "createdAt" => $pago->created_at->toISOString(),
            "pagoProcesos" => $pago->pagoProcesos->map(function ($pagoProceso) {
                return [
                    "id" => $pagoProceso->id,
                    "actividad" => $pagoProceso->actividad,
                    "cantidad" => $pagoProceso->cantidad,
                    "total" => $pagoProceso->total
                ];
            })->toArray()
        ];
        return $jsonData;
    }


    public function sendMessageToPrinter($json)
    {
        $printerApiUrl = env('PRINTER_POS_API_URL', 'http://localhost:9001/api/print-ticket');

        if (!$printerApiUrl) {
            return response()->json(['error' => 'La URL de la impresora no está configurada'], 500);
        }

        // Inicializar cURL
        $ch = curl_init($printerApiUrl);

        // Configurar opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));

        // Ejecutar la solicitud
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);

        // Cerrar cURL
        curl_close($ch);

        // Manejar errores o devolver la respuesta
        if ($curlError) {
            return response()->json(['error' => 'Error en la solicitud CURL: ' . $curlError], 500);
        }

        return response()->json([
            'message' => 'Solicitud enviada correctamente',
            'response' => json_decode($response, true),
            'status' => $httpCode
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pago = Pago::find($id);
        return view('pagos.show')->with('pago', $pago);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
