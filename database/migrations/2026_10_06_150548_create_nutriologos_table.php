<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nutriologos', function (Blueprint $table) {
            $table->id('id_nutriologo');

            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('correo', 150)->unique();
            $table->string('password');

            $table->string('telefono', 20)->nullable();
            $table->string('cedula_profesional', 50)->nullable()->unique();

            $table->string('rol', 30)
                ->default('SUPERADMINISTRADOR');

            $table->boolean('activo')
                ->default(true);

            $table->rememberToken();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nutriologos');
    }
};