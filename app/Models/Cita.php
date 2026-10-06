<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cita extends Model
{
    protected $table = 'citas';

    protected $primaryKey = 'id_cita';

    protected $fillable = [
        'id_cliente',
        'id_nutriologo',
        'nombre',
        'apellido',
        'correo',
        'dia',
        'hora',
        'motivo_consulta',
        'estado',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'dia' => 'date',
            'hora' => 'string',
        ];
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(
            Cliente::class,
            'id_cliente',
            'id_cliente'
        );
    }

    public function nutriologo(): BelongsTo
    {
        return $this->belongsTo(
            Nutriologo::class,
            'id_nutriologo',
            'id_nutriologo'
        );
    }

    public function formulario(): HasOne
    {
        return $this->hasOne(
            Formulario::class,
            'id_cita',
            'id_cita'
        );
    }

    public function getNombreCompletoAttribute(): string
    {
        return trim($this->nombre . ' ' . $this->apellido);
    }
}