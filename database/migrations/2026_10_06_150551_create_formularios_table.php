<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formularios', function (Blueprint $table) {
            $table->id('id_formulario');

            /*
            |--------------------------------------------------------------------------
            | Relaciones
            |--------------------------------------------------------------------------
            */

            $table->foreignId('id_cliente')
                ->constrained(
                    table: 'clientes',
                    column: 'id_cliente'
                )
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('id_nutriologo')
                ->constrained(
                    table: 'nutriologos',
                    column: 'id_nutriologo'
                )
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('id_cita')
                ->nullable()
                ->constrained(
                    table: 'citas',
                    column: 'id_cita'
                )
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Expediente
            |--------------------------------------------------------------------------
            */

            $table->string('numero_expediente', 50);

            /*
            |--------------------------------------------------------------------------
            | Datos solicitados
            |--------------------------------------------------------------------------
            */

            $table->string('nombre', 200);

            $table->decimal('peso', 6, 2)
                ->nullable();

            $table->decimal('estatura', 4, 2)
                ->nullable();

            $table->decimal('imc', 5, 2)
                ->nullable();

            $table->decimal('porcentaje_grasa', 5, 2)
                ->nullable();

            $table->string('contacto', 150)
                ->nullable();

            $table->text('antecedentes')
                ->nullable();

            $table->date('fecha_nacimiento')
                ->nullable();

            $table->unsignedTinyInteger('edad')
                ->nullable();

            $table->text('motivo_consulta');

            /*
            |--------------------------------------------------------------------------
            | Datos clínicos adicionales
            |--------------------------------------------------------------------------
            */

            $table->decimal('circunferencia_cintura', 6, 2)
                ->nullable();

            $table->decimal('circunferencia_cadera', 6, 2)
                ->nullable();

            $table->decimal('masa_muscular', 6, 2)
                ->nullable();

            $table->decimal('agua_corporal', 5, 2)
                ->nullable();

            $table->text('alergias')
                ->nullable();

            $table->text('medicamentos')
                ->nullable();

            $table->text('habitos_alimenticios')
                ->nullable();

            $table->text('actividad_fisica')
                ->nullable();

            $table->text('diagnostico')
                ->nullable();

            $table->text('plan_nutricional')
                ->nullable();

            $table->text('observaciones')
                ->nullable();

            $table->date('fecha_consulta');

            $table->timestamps();

            $table->index('numero_expediente');
            $table->index('fecha_consulta');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formularios');
    }
};