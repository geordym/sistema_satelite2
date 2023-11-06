<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tarifa;

class TarifaController extends Controller
{
    //

    public function index(){
        $tarifas = Tarifa::all();
        return view('tarifas.index')->with('tarifas', $tarifas);
    }

    public function create(Request $request){
        $name = $request->input('name');
        $description = $request->input('description');
        $cost = $request->input('cost');

        Tarifa::create([
            'name' => $name,
            'description' => $description,
            'cost' => $cost,
        ]);

        return redirect('/admin/tarifas'); // Redirige al usuario a la página de inicio de sesión o a la página que desees después del cierre de sesión.

    }

}
