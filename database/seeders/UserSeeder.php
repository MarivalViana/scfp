<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Exemplo para criar um usuário administrador
        User::create([
            'name' => 'Admin',
            'email' => 'marivalvmf@gmail.com',
            'password' => Hash::make('dbo@1234'), // Use uma senha forte!
        ]);
    }
}
