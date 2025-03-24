<?php

namespace App\Http\Controllers;

use App\Models\Operador;
use Illuminate\Http\Request;

class OperadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $operadores = Operador::all();
        return view('operadores.index')->with('operadores', $operadores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('operadores.create');
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
            'nombre' => 'required|string|max:255',
        ]);

        try {
            // Crear el operador
            $operador = new Operador();
            $operador->nombre = $request->nombre;
            $operador->save();

            // Redireccionar con mensaje de éxito
            return redirect()->route('admin.operadores.index')->with('success', 'Operador creado correctamente.');
        } catch (\Exception $e) {
            // Manejar errores y redireccionar con mensaje de error
            return redirect()->back()->with('error', 'Ocurrió un error al crear el operador.');
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
        $operador = Operador::find($id);
        return view('operadores.show')->with('operador', $operador);
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
        $operador = Operador::find($id);
        return view('operadores.edit')->with('operador', $operador);
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
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        // Buscar el operador en la base de datos
        $operador = Operador::findOrFail($id);

        // Actualizar los datos del operador
        $operador->update([
            'nombre' => $request->nombre,
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.operadores.index')->with('success', 'Operador actualizado correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Buscar el operador en la base de datos
        $operador = Operador::findOrFail($id);

        // Eliminar el operador
        $operador->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.operadores.index')->with('success', 'Operador eliminado correctamente.');
    }
}
