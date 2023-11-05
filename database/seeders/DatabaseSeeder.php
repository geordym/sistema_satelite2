<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\Role;
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
    }
}
