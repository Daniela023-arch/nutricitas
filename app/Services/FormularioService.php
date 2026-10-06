<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Formulario;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FormularioService
{
    public function calcularIMC(
        ?float $peso,
        ?float $estatura
    ): ?float {
        if (
            $peso === null ||
            $estatura === null ||
            $peso <= 0 ||
            $estatura <= 0
        ) {
            return null;
        }

        return round(
            $peso / ($estatura * $estatura),
            2
        );
    }

    public function calcularEdad(
        ?string $fechaNacimiento
    ): ?int {
        if (!$fechaNacimiento) {
            return null;
        }

        return Carbon::parse(
            $fechaNacimiento
        )->age;
    }

    public function obtenerNumeroExpediente(
        Cliente $cliente
    ): string {
        $formularioAnterior = Formulario::query()
            ->where(
                'id_cliente',
                $cliente->id_cliente
            )
            ->orderBy('id_formulario')
            ->first();

        if ($formularioAnterior) {
            return $formularioAnterior
                ->numero_expediente;
        }

        return 'EXP-' . str_pad(
            (string) $cliente->id_cliente,
            5,
            '0',
            STR_PAD_LEFT
        );
    }

    public function crearFormulario(
        array $datos
    ): Formulario {
        return DB::transaction(
            function () use ($datos) {

                $cliente = Cliente::findOrFail(
                    $datos['id_cliente']
                );

                $datos['numero_expediente'] =
                    $this->obtenerNumeroExpediente(
                        $cliente
                    );

                $datos['imc'] =
                    $this->calcularIMC(
                        isset($datos['peso'])
                            ? (float) $datos['peso']
                            : null,

                        isset($datos['estatura'])
                            ? (float) $datos['estatura']
                            : null
                    );

                $datos['edad'] =
                    $this->calcularEdad(
                        $datos['fecha_nacimiento']
                            ?? null
                    );

                return Formulario::create(
                    $datos
                );
            }
        );
    }

    public function actualizarFormulario(
        Formulario $formulario,
        array $datos
    ): Formulario {
        return DB::transaction(
            function () use (
                $formulario,
                $datos
            ) {

                $cliente =
                    Cliente::findOrFail(
                        $datos['id_cliente']
                    );

                /*
                 * Si se cambia de cliente,
                 * el expediente debe corresponder
                 * al nuevo cliente.
                 */
                if (
                    $formulario->id_cliente
                    !== $cliente->id_cliente
                ) {
                    $datos['numero_expediente'] =
                        $this->obtenerNumeroExpediente(
                            $cliente
                        );
                } else {
                    $datos['numero_expediente'] =
                        $formulario
                            ->numero_expediente;
                }

                $datos['imc'] =
                    $this->calcularIMC(
                        isset($datos['peso'])
                            ? (float) $datos['peso']
                            : null,

                        isset($datos['estatura'])
                            ? (float) $datos['estatura']
                            : null
                    );

                $datos['edad'] =
                    $this->calcularEdad(
                        $datos['fecha_nacimiento']
                            ?? null
                    );

                $formulario->update(
                    $datos
                );

                return $formulario->refresh();
            }
        );
    }
}