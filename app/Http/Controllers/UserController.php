<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //

    public function index(){
        return view('home'); // Asegúrate de que esta vista exista
    }


    public function profile(){
        $user = auth()->user();
        return view('profile', compact('user'));
    }

    public function users(){
        $users = User::all();
        return view('users')->with('users', $users);
    }

    public function create(Request $request){
        $name = $request->input('nombre');
        $email = $request->input('email');
        $id_rol = $request->input('rol');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($email),
            'id_rol' => $id_rol, // Asigna el ID del segundo rol al usuario 2
        ]);

        return redirect('/admin/users');

    }


}
