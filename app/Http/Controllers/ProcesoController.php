<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Entrada;
use App\Models\Operador;
use App\Models\Proceso;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProcesoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fecha_actual = Carbon::now();
        $fecha = $request->input('fecha') ?? $fecha_actual;
        $fecha_formateada = Carbon::parse($fecha)->format('Y-m-d');

        //dd($fecha_formateada);

        // Obtener la fecha inicial (medianoche)
        $fecha_inicio = Carbon::parse($fecha)->startOfDay();

        // Obtener la fecha final (un minuto antes de la medianoche del día siguiente)
        $fecha_fin = Carbon::parse($fecha)->endOfDay();

        //dd($fecha);
        $procesos = Proceso::with(['operador', 'actividad'])->whereBetween('fecha_procesado', [$fecha_inicio, $fecha_fin])->get();
        return view('procesos.index')->with('procesos', $procesos)->with('fecha', $fecha);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $actividades = Actividad::all();
        $entradas = Entrada::where('estado', 'recibido')
            ->orWhere('estado', 'procesando')
            ->get();

        $operadores = Operador::all();

        $fecha_actual = Carbon::now();
        return view('procesos.create')
            ->with('fecha_actual', $fecha_actual)
            ->with('actividades', $actividades)
            ->with('entradas', $entradas)
            ->with('operadores', $operadores);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validación de datos
            $validator = Validator::make($request->all(), [
                'descripcion' => 'required|string|max:255',
                'cantidad' => 'required|integer|min:1',
                'fecha_procesado' => 'required|date', // Asegúrate de que coincida con el formato datetime-local
                'actividad_id' => 'required|exists:actividades,id',
                'entrada_id' => 'required|exists:entradas,id',
                'operador_id' => 'required|exists:operadores,id',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            // Creación del proceso
            $proceso = new Proceso();
            $proceso->descripcion = $request->input('descripcion');
            $proceso->cantidad = $request->input('cantidad');
            $proceso->fecha_procesado = $request->input('fecha_procesado'); // Asigna la fecha y hora actual del servidor
            $proceso->actividad_id = $request->input('actividad_id');
            $proceso->entrada_id = $request->input('entrada_id');
            $proceso->operador_id = $request->input('operador_id');

            $proceso->save();

            // Redireccionamiento a una ruta o vista
            return redirect()->route('admin.procesos.index'); // Reemplaza 'nombre_de_la_ruta' por la ruta a la que quieras redirigir

        } catch (Exception $e) {
            dd($e);
            // Manejo de la excepción
            return back()->withInput()->withErrors(['error' => 'Hubo un problema al procesar la solicitud. Por favor, inténtalo de nuevo. ' . $e]);
            // Puedes personalizar el mensaje de error según tus necesidades
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        try {
            // Buscar la entrada por su ID
            $proceso = Proceso::findOrFail($id);

            // Eliminar la entrada
            $proceso->delete();

            // Redireccionar a la página de entradas con un mensaje de éxito
            return redirect()->route('admin.procesos.index')->with('success', 'Proceso eliminado correctamente.');
        } catch (\Exception $e) {
            // Si ocurre algún error, redireccionar con un mensaje de error
            return redirect()->back()->with('error', 'Error al eliminar el proceso: ' . $e->getMessage());
        }
    }
}
