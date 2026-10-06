<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Nutriologo extends Authenticatable
{
    use Notifiable;

    protected $table = 'nutriologos';

    protected $primaryKey = 'id_nutriologo';

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'password',
        'telefono',
        'cedula_profesional',
        'rol',
        'activo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function citas()
    {
        return $this->hasMany(
            Cita::class,
            'id_nutriologo',
            'id_nutriologo'
        );
    }

    public function formularios()
    {
        return $this->hasMany(
            Formulario::class,
            'id_nutriologo',
            'id_nutriologo'
        );
    }

    public function getAuthPasswordName(): string
    {
        return 'password';
    }
}