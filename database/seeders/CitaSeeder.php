<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Nutriologo;
use Illuminate\Database\Seeder;

class CitaSeeder extends Seeder
{
    public function run(): void
    {
        $nutriologo = Nutriologo::first();

        if (!$nutriologo) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Cliente 1
        |--------------------------------------------------------------------------
        */

        $cliente1 = Cliente::create([
            'nombre' => 'Ana',
            'apellido' => 'Martínez',
            'correo' => 'ana@example.com',
            'telefono' => '5512345678',
            'fecha_nacimiento' => '1998-04-15',
        ]);

        Cita::create([
            'id_cliente' => $cliente1->id_cliente,
            'id_nutriologo' => $nutriologo->id_nutriologo,
            'nombre' => $cliente1->nombre,
            'apellido' => $cliente1->apellido,
            'correo' => $cliente1->correo,
            'dia' => now()->addDays(2)->toDateString(),
            'hora' => '10:00:00',
            'motivo_consulta' => 'Consulta nutricional inicial.',
            'estado' => 'PENDIENTE',
            'observaciones' => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Cliente 2
        |--------------------------------------------------------------------------
        */

        $cliente2 = Cliente::create([
            'nombre' => 'Carlos',
            'apellido' => 'Ramírez',
            'correo' => 'carlos@example.com',
            'telefono' => '5587654321',
            'fecha_nacimiento' => '1995-08-22',
        ]);

        Cita::create([
            'id_cliente' => $cliente2->id_cliente,
            'id_nutriologo' => $nutriologo->id_nutriologo,
            'nombre' => $cliente2->nombre,
            'apellido' => $cliente2->apellido,
            'correo' => $cliente2->correo,
            'dia' => now()->addDays(3)->toDateString(),
            'hora' => '12:00:00',
            'motivo_consulta' => 'Seguimiento de alimentación y composición corporal.',
            'estado' => 'CONFIRMADA',
            'observaciones' => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Cliente 3
        |--------------------------------------------------------------------------
        */

        $cliente3 = Cliente::create([
            'nombre' => 'Sofía',
            'apellido' => 'Hernández',
            'correo' => 'sofia@example.com',
            'telefono' => '5545678901',
            'fecha_nacimiento' => '2001-02-10',
        ]);

        Cita::create([
            'id_cliente' => $cliente3->id_cliente,
            'id_nutriologo' => $nutriologo->id_nutriologo,
            'nombre' => $cliente3->nombre,
            'apellido' => $cliente3->apellido,
            'correo' => $cliente3->correo,
            'dia' => now()->addDays(4)->toDateString(),
            'hora' => '16:00:00',
            'motivo_consulta' => 'Mejorar hábitos alimenticios.',
            'estado' => 'PENDIENTE',
            'observaciones' => null,
        ]);
    }
}