<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Geremy Admin',
            'email'    => 'geremy_rko56@hotmail.com',
            'password' => Hash::make('NOMERCY1881'),  // contraseña encriptada
        ]);

        // Opcional: mensaje en consola para confirmar
        $this->command->info('Usuario administrador creado exitosamente:');
        $this->command->info('Email: geremy_rko56@hotmail.com');
        $this->command->info('Contraseña: NOMERCY1881');
    }
}