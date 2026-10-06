<?php

namespace App\Services;

use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Nutriologo;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CitaService
{
    public function horarioDisponible(
        string $dia,
        string $hora,
        int $idNutriologo,
        ?int $ignorarCita = null
    ): bool {
        $query = Cita::query()
            ->where('id_nutriologo', $idNutriologo)
            ->whereDate('dia', $dia)
            ->where('hora', $hora)
            ->whereNotIn('estado', ['CANCELADA']);

        if ($ignorarCita !== null) {
            $query->where('id_cita', '!=', $ignorarCita);
        }

        return !$query->exists();
    }

    public function crearCita(array $datos): Cita
    {
        return DB::transaction(function () use ($datos) {

            $nutriologo = Nutriologo::query()
                ->where('activo', true)
                ->firstOrFail();

            if (!$this->horarioDisponible(
                $datos['dia'],
                $datos['hora'],
                $nutriologo->id_nutriologo
            )) {
                throw new RuntimeException(
                    'El horario seleccionado no está disponible.'
                );
            }

            $cliente = Cliente::query()
                ->where('correo', $datos['correo'])
                ->first();

            if (!$cliente) {
                $cliente = Cliente::create([
                    'nombre' => $datos['nombre'],
                    'apellido' => $datos['apellido'],
                    'correo' => $datos['correo'],
                    'telefono' => $datos['telefono'] ?? null,
                    'fecha_nacimiento' => null,
                ]);
            } else {
                $cliente->update([
                    'nombre' => $datos['nombre'],
                    'apellido' => $datos['apellido'],
                    'telefono' => $datos['telefono']
                        ?? $cliente->telefono,
                ]);
            }

            try {
                return Cita::create([
                    'id_cliente' => $cliente->id_cliente,
                    'id_nutriologo' => $nutriologo->id_nutriologo,

                    'nombre' => $datos['nombre'],
                    'apellido' => $datos['apellido'],
                    'correo' => $datos['correo'],

                    'dia' => $datos['dia'],
                    'hora' => $datos['hora'],

                    'motivo_consulta' => $datos['motivo_consulta'],

                    'estado' => 'PENDIENTE',
                    'observaciones' => null,
                ]);
            } catch (QueryException $exception) {
                /*
                 * La base de datos conserva una restricción UNIQUE.
                 * Si dos solicitudes intentaran reservar exactamente
                 * el mismo horario simultáneamente, esta captura evita
                 * mostrar el error SQL directamente al cliente.
                 */

                if ($exception->getCode() === '23000') {
                    throw new RuntimeException(
                        'El horario seleccionado acaba de ser ocupado. Selecciona otro horario.'
                    );
                }

                throw $exception;
            }
        });
    }

    public function cambiarEstado(Cita $cita, string $estado): Cita
    {
        $estadosPermitidos = [
            'PENDIENTE',
            'CONFIRMADA',
            'COMPLETADA',
            'CANCELADA',
        ];

        if (!in_array($estado, $estadosPermitidos, true)) {
            throw new RuntimeException(
                'El estado seleccionado no es válido.'
            );
        }

        $cita->update([
            'estado' => $estado,
        ]);

        return $cita->refresh();
    }
}