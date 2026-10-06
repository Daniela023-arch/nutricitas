<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $primaryKey = 'id_cliente';

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'telefono',
        'fecha_nacimiento',
    ];

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
        ];
    }

    public function citas(): HasMany
    {
        return $this->hasMany(
            Cita::class,
            'id_cliente',
            'id_cliente'
        );
    }

    public function formularios(): HasMany
    {
        return $this->hasMany(
            Formulario::class,
            'id_cliente',
            'id_cliente'
        );
    }

    public function getNombreCompletoAttribute(): string
    {
        return trim($this->nombre . ' ' . $this->apellido);
    }
}