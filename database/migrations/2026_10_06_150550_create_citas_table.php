<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id('id_cita');

            /*
            |--------------------------------------------------------------------------
            | Relaciones
            |--------------------------------------------------------------------------
            */

            $table->foreignId('id_cliente')
                ->nullable()
                ->constrained(
                    table: 'clientes',
                    column: 'id_cliente'
                )
                ->nullOnDelete();

            $table->foreignId('id_nutriologo')
                ->nullable()
                ->constrained(
                    table: 'nutriologos',
                    column: 'id_nutriologo'
                )
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Información solicitada para la cita
            |--------------------------------------------------------------------------
            */

            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('correo', 150);

            $table->date('dia');
            $table->time('hora');

            $table->text('motivo_consulta');

            /*
            |--------------------------------------------------------------------------
            | Gestión de la cita
            |--------------------------------------------------------------------------
            */

            $table->string('estado', 30)
                ->default('PENDIENTE');

            $table->text('observaciones')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Restricción de horario
            |--------------------------------------------------------------------------
            |
            | Impide que existan dos citas exactamente a la misma
            | fecha y hora para el mismo nutriólogo.
            |
            */

            $table->unique(
                ['id_nutriologo', 'dia', 'hora'],
                'citas_nutriologo_dia_hora_unique'
            );

            $table->index('dia');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};