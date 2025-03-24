<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $actividades = Actividad::all();
        return view('actividades.index')->with('actividades', $actividades);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('actividades.create');

    }

 
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'valor_unitario' => 'required|numeric|min:0',
        ]);
    
        // Creación de la actividad
        Actividad::create([
            'nombre' => $request->nombre,
            'valor_unitario' => $request->valor_unitario,
        ]);
    
        // Redirección con mensaje de éxito
        return redirect()->route('admin.actividades.index')->with('success', 'Actividad creada con éxito.');
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
        $actividad = Actividad::find($id);
        return view('actividades.show')->with('actividad', $actividad);
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
        $actividad = Actividad::find($id);
        return view('actividades.edit')->with('actividad', $actividad);

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
        // Validar los datos ingresados
        $request->validate([
            'nombre' => 'required|string|max:255',
            'valor_unitario' => 'required|numeric|min:0',
        ]);
    
        // Buscar la actividad por ID
        $actividad = Actividad::findOrFail($id);
    
        // Actualizar los datos de la actividad
        $actividad->update([
            'nombre' => $request->nombre,
            'valor_unitario' => $request->valor_unitario,
        ]);
    
        // Redireccionar con un mensaje de éxito
        return redirect()->route('admin.actividades.index')->with('success', 'Actividad actualizada con éxito.');
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
