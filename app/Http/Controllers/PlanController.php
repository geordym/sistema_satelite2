<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Plan;


class PlanController extends Controller
{
    //

    public function index(){

        $plans = Plan::all();
        return view('planes.index')->with('plans', $plans);
    }

    public function create(Request $request){
        $name = $request->input('name');
        $description = $request->input('description');
        $cost = $request->input('cost');

        Plan::create([
            'name' => $name,
            'description' => $description,
            'cost' => $cost,
        ]);

        return redirect('/admin/planes'); // Redirige al usuario a la página de inicio de sesión o a la página que desees después del cierre de sesión.

    }
}
