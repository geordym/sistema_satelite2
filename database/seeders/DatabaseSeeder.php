<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\Canal;
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


        Canal::create([
            'key' => 'canal 1',
            'value' => 'asdsadasd',
            'type' => 'test1',
            'number' => 123

        ]);

        Canal::create([
            'key' => 'canal 1',
            'value' => 'asdsadasd',
            'type' => 'test1',
            'number' => 1

        ]);



    }
}
