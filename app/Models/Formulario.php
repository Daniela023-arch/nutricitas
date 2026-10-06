<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Formulario extends Model
{
    protected $table = 'formularios';

    protected $primaryKey = 'id_formulario';

    protected $fillable = [
        'id_cliente',
        'id_nutriologo',
        'id_cita',
        'numero_expediente',
        'nombre',
        'peso',
        'estatura',
        'imc',
        'porcentaje_grasa',
        'contacto',
        'antecedentes',
        'fecha_nacimiento',
        'edad',
        'motivo_consulta',
        'circunferencia_cintura',
        'circunferencia_cadera',
        'masa_muscular',
        'agua_corporal',
        'alergias',
        'medicamentos',
        'habitos_alimenticios',
        'actividad_fisica',
        'diagnostico',
        'plan_nutricional',
        'observaciones',
        'fecha_consulta',
    ];

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
            'fecha_consulta' => 'date',
            'peso' => 'decimal:2',
            'estatura' => 'decimal:2',
            'imc' => 'decimal:2',
            'porcentaje_grasa' => 'decimal:2',
            'circunferencia_cintura' => 'decimal:2',
            'circunferencia_cadera' => 'decimal:2',
            'masa_muscular' => 'decimal:2',
            'agua_corporal' => 'decimal:2',
            'edad' => 'integer',
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

    public function cita(): BelongsTo
    {
        return $this->belongsTo(
            Cita::class,
            'id_cita',
            'id_cita'
        );
    }
}