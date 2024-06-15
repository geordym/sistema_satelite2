<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EntradaController extends Controller
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
        $entradas = Entrada::whereBetween('fecha_entrada', [$fecha_inicio, $fecha_fin])->get();
        return view('entradas.index')->with('entradas', $entradas)->with('fecha', $fecha);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $fecha_actual = Carbon::now();

        return view('entradas.create')->with('fecha_actual', $fecha_actual);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'fecha_entrada' => 'required|date',
        ]);

        try {
            // Crear una nueva instancia del modelo Entrada con los datos del formulario
            $entrada = new Entrada();
            $entrada->descripcion = $request->input('descripcion');
            $entrada->cantidad = $request->input('cantidad');
            $entrada->fecha_entrada = $request->input('fecha_entrada');

            // Guardar la entrada en la base de datos
            $entrada->save();

            // Redireccionar a la página de entradas con un mensaje de éxito
            return redirect()->route('admin.entradas.index')->with('success', 'Entrada creada correctamente.');
        } catch (\Exception $e) {
            // Si ocurre algún error, redireccionar con un mensaje de error
            return redirect()->back()->withInput()->with('error', 'Error al crear la entrada: ' . $e->getMessage());
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
        try {
            // Buscar la entrada por su ID
            $entrada = Entrada::findOrFail($id);

            // Pasar la entrada a la vista de edición
            return view('entradas.edit', compact('entrada'));
        } catch (\Exception $e) {
            // Si ocurre algún error, redireccionar con un mensaje de error
            return redirect()->back()->with('error', 'Error al editar la entrada: ' . $e->getMessage());
        }
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
        try {
            // Buscar la entrada por su ID
            $entrada = Entrada::findOrFail($id);

            // Validar los datos del formulario
            $request->validate([
                'descripcion' => 'required|string|max:255',
                'cantidad' => 'required|integer|min:1',
                'fecha_entrada' => 'required|date',
            ]);

            // Actualizar los datos de la entrada
            $entrada->descripcion = $request->input('descripcion');
            $entrada->cantidad = $request->input('cantidad');
            $entrada->fecha_entrada = $request->input('fecha_entrada');

            // Guardar los cambios en la entrada
            $entrada->save();

            // Redireccionar a la página de entradas con un mensaje de éxito
            return redirect()->route('admin.entradas.index')->with('success', 'Entrada actualizada correctamente.');
        } catch (\Exception $e) {
            // Si ocurre algún error, redireccionar con un mensaje de error
            return redirect()->back()->withInput()->with('error', 'Error al actualizar la entrada: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      //  dd($id);
        try {
            // Buscar la entrada por su ID
            $entrada = Entrada::findOrFail($id);

            // Eliminar la entrada
            $entrada->delete();

            // Redireccionar a la página de entradas con un mensaje de éxito
            return redirect()->route('admin.entradas.index')->with('success', 'Entrada eliminada correctamente.');
        } catch (\Exception $e) {
            // Si ocurre algún error, redireccionar con un mensaje de error
            return redirect()->back()->with('error', 'Error al eliminar la entrada: ' . $e->getMessage());
        }
    }
}
