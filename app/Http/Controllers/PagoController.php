<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Operador;
use App\Models\Pago;
use App\Models\Proceso;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $selectedOperator = $request->input('operador_id') ?? 0 ;

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
        foreach($procesos_operador as $proceso){
            if($proceso->status !=="PAGADO"){
                $procesos_operador_unpayment[] = $proceso;
            }
        }

        $actividades = Actividad::all();


        return view('pagos.create')->with('operador', $operador)->with('procesos_operador', $procesos_operador_unpayment)->with('actividades', $actividades);
    }

    public function create_payment(Request $request){
        $operador_id = $request->input('operador_id');
        $procesos_ids = $request->input('selected_processes');
        $procesos_ids_array = explode(',', $procesos_ids);
        $processes_to_payment = Proceso::find($procesos_ids_array);

        $total_to_payment = 0;
        foreach($processes_to_payment as $proccess){
            $total_to_payment += $proccess->calcularValor();
        }

        $operador = Operador::find($operador_id);


        return view('pagos.create_payment')->with('operador',$operador)->
        with('operador_procesos', $processes_to_payment)->
        with('total_to_payment', $total_to_payment)->
        with('procesos_ids', $procesos_ids)
        ;
    }

    public function download_payment($id){
        $pago = Pago::find($id);



    }

    public function getPaymentData($id){
        $pago = Pago::with(['operador', 'procesos'])->where('id', $id)->first();
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

                $pago->pagoProcesos()->create(['pago_id' => $pago->id, 'proceso_id' => $proceso_id]);
                $proceso->status = "PAGADO";
                $proceso->save();
            }

            // Retornar el ID del pago creado
            return $pago->id;
        });

        return redirect()->route('admin.pagos.index')->with('success', 'Pago creado con éxito.')->with('pago_creado', $pago_creado);
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
