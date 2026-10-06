<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('id_cliente');

            $table->string('nombre', 100);
            $table->string('apellido', 100);

            $table->string('correo', 150)
                ->nullable();

            $table->string('telefono', 20)
                ->nullable();

            $table->date('fecha_nacimiento')
                ->nullable();

            $table->timestamps();

            $table->index('correo');
            $table->index('telefono');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};