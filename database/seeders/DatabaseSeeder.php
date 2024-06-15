<?php

namespace Database\Seeders;

use App\Models\Actividad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\Canal;
use App\Models\Operador;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {




        // Crear dos usuarios y asignar roles
        User::create([
            'name' => 'User 1',
            'email' => 'user1@example.com',
            'password' => bcrypt('password1'),
        ]);

        User::create([
            'name' => 'User 2',
            'email' => 'user2@example.com',
            'password' => bcrypt('password2'),
        ]);


        Actividad::create([
            'nombre' => 'Fileteado Grapado',
            'valor_unitario' => '26',
        ]);

        Actividad::create([
            'nombre' => 'Fileteado Directo',
            'valor_unitario' => '54',
        ]);

        Actividad::create([
            'nombre' => 'Grapado',
            'valor_unitario' => '26',
        ]);


        Actividad::create([
            'nombre' => 'Empalillado',
            'valor_unitario' => '20',
        ]);


        Operador::create([
            'nombre' => "GEORDY MONTENEGRO"
        ]);


        Operador::create([
            'nombre' => "DAMARIS MOSQUERA"
        ]);


        Operador::create([
            'nombre' => "EUDES MONTENEGRO"
        ]);

    }
}
