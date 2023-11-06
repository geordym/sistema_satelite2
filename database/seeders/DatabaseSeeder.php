<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\Role;
use App\Models\User;
use App\Models\Plan;
use App\Models\Tarifa;
use App\Models\Client;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Crear dos roles
        $role1 = Role::create([
            'name' => 'VENDEDOR'
        ]);

        $role2 = Role::create([
            'name' => 'SUPERADMINISTRADOR'
        ]);

        $role3 = Role::create([
            'name' => 'ADMINISTRADOR'
        ]);




        // Crear dos usuarios y asignar roles
        User::create([
            'name' => 'User 1',
            'email' => 'user1@example.com',
            'password' => bcrypt('password1'),
            'id_rol' => $role1->id, // Asigna el ID del primer rol al usuario 1
        ]);

        User::create([
            'name' => 'User 2',
            'email' => 'user2@example.com',
            'password' => bcrypt('password2'),
            'id_rol' => $role2->id, // Asigna el ID del segundo rol al usuario 2
        ]);

        Plan::create([
            'name' => 'INTERNET 4MB',
            'description' => 'ACCeSO A Internet',
            'cost' => 200,
        ]);

        Plan::create([
            'name' => 'INTERNET 8MB',
            'description' => 'ACCeSO A Internet',
            'cost' => 200,
        ]);

        Plan::create([
            'name' => 'INTERNET 24MB',
            'description' => 'ACCeSO A Internet',
            'cost' => 200,
        ]);

        Tarifa::create([
            'name' => 'AFILIACION',
            'description' => 'COSTO DE AFILIARSE',
            'cost' => 200,
        ]);

        Tarifa::create([
            'name' => 'RECONEXION',
            'description' => 'Costo por reconectar servicio',
            'cost' => 200,
        ]);

        Client::create([
            'names' => 'LUIS PEREZ',
            'surnames' => 'TORReS CARRILLO',
            'phone' => 3024124124,
            'email' => 'ggear@gmail.com',
            'address' => 'AV calle 4',
            'id_type' => 'CEDULA CIUDADANIA',
            'identification' => 214214124
        ]);

    }
}
