<?php

namespace Database\Seeders;

use App\Models\Nutriologo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NutriologoSeeder extends Seeder
{
    public function run(): void
    {
        Nutriologo::create([
            'nombre' => 'Nutriólogo',
            'apellido' => 'Administrador',
            'correo' => 'nutriologo@nutricitas.com',
            'password' => Hash::make('Nutri2026!'),
            'telefono' => '5555555555',
            'cedula_profesional' => 'NUT-2026-001',
            'rol' => 'SUPERADMINISTRADOR',
            'activo' => true,
        ]);
    }
}