<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Services\CitaService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class CitaController extends Controller
{
    public function __construct(
        private CitaService $citaService
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | Registrar cita desde el sitio público
    |--------------------------------------------------------------------------
    */

    public function storePublic(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
            ],

            'apellido' => [
                'required',
                'string',
                'max:100',
            ],

            'correo' => [
                'required',
                'email',
                'max:150',
            ],

            'telefono' => [
                'nullable',
                'string',
                'max:20',
            ],

            'dia' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'hora' => [
                'required',
                'date_format:H:i',
            ],

            'motivo_consulta' => [
                'required',
                'string',
                'max:1500',
            ],
        ]);

        /*
         * El input HTML type="time" envía normalmente:
         *
         * 10:00
         *
         * Lo convertimos a:
         *
         * 10:00:00
         *
         * para mantener el mismo formato que SQLite.
         */
        $datos['hora'] = Carbon::createFromFormat(
            'H:i',
            $datos['hora']
        )->format('H:i:s');

        try {

            $this->citaService->crearCita($datos);

            return redirect()
                ->route('citas.publicas')
                ->with(
                    'success',
                    'Tu cita fue agendada correctamente.'
                );

        } catch (RuntimeException $exception) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    $exception->getMessage()
                );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Consultar disponibilidad
    |--------------------------------------------------------------------------
    */

    public function disponibilidad(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'dia' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'hora' => [
                'required',
                'date_format:H:i',
            ],
        ]);

        $hora = Carbon::createFromFormat(
            'H:i',
            $datos['hora']
        )->format('H:i:s');

        $nutriologo = \App\Models\Nutriologo::query()
            ->where('activo', true)
            ->first();

        if (!$nutriologo) {
            return response()->json([
                'disponible' => false,
                'mensaje' => 'No hay un nutriólogo disponible.',
            ]);
        }

        $disponible = $this->citaService
            ->horarioDisponible(
                $datos['dia'],
                $hora,
                $nutriologo->id_nutriologo
            );

        return response()->json([
            'disponible' => $disponible,

            'mensaje' => $disponible
                ? 'Horario disponible.'
                : 'Ese horario no está disponible.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Listado administrativo
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        $query = Cita::query()
            ->with([
                'cliente',
                'formulario',
            ]);

        if ($request->filled('buscar')) {

            $buscar = trim(
                $request->string('buscar')->toString()
            );

            $query->where(
                function ($consulta) use ($buscar) {

                    $consulta
                        ->where(
                            'nombre',
                            'like',
                            "%{$buscar}%"
                        )
                        ->orWhere(
                            'apellido',
                            'like',
                            "%{$buscar}%"
                        )
                        ->orWhere(
                            'correo',
                            'like',
                            "%{$buscar}%"
                        );
                }
            );
        }

        if ($request->filled('estado')) {
            $query->where(
                'estado',
                $request->estado
            );
        }

        if ($request->filled('fecha')) {
            $query->whereDate(
                'dia',
                $request->fecha
            );
        }

        $citas = $query
            ->orderByDesc('dia')
            ->orderBy('hora')
            ->paginate(10)
            ->withQueryString();

        return view(
            'citas.index',
            compact('citas')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Calendario
    |--------------------------------------------------------------------------
    */

    public function calendario(): View
    {
        return view('citas.calendario');
    }

    /*
    |--------------------------------------------------------------------------
    | Datos JSON para el calendario
    |--------------------------------------------------------------------------
    */

    public function eventosCalendario(
        Request $request
    ): JsonResponse {

        $query = Cita::query()
            ->orderBy('dia')
            ->orderBy('hora');

        if ($request->filled('inicio')) {
            $query->whereDate(
                'dia',
                '>=',
                $request->inicio
            );
        }

        if ($request->filled('fin')) {
            $query->whereDate(
                'dia',
                '<=',
                $request->fin
            );
        }

        $citas = $query->get();

        $eventos = $citas->map(
            function (Cita $cita) {

                return [
                    'id' => $cita->id_cita,

                    'nombre' =>
                        $cita->nombre . ' ' .
                        $cita->apellido,

                    'correo' => $cita->correo,

                    'dia' =>
                        $cita->dia->format(
                            'Y-m-d'
                        ),

                    'hora' =>
                        substr(
                            $cita->hora,
                            0,
                            5
                        ),

                    'motivo' =>
                        $cita->motivo_consulta,

                    'estado' =>
                        $cita->estado,
                ];
            }
        );

        return response()->json($eventos);
    }

    /*
    |--------------------------------------------------------------------------
    | Cambiar estado de una cita
    |--------------------------------------------------------------------------
    */

    public function updateEstado(
        Request $request,
        Cita $cita
    ): RedirectResponse {

        $datos = $request->validate([
            'estado' => [
                'required',
                'in:PENDIENTE,CONFIRMADA,COMPLETADA,CANCELADA',
            ],
        ]);

        try {

            $this->citaService
                ->cambiarEstado(
                    $cita,
                    $datos['estado']
                );

            return back()->with(
                'success',
                'El estado de la cita fue actualizado.'
            );

        } catch (RuntimeException $exception) {

            return back()->with(
                'error',
                $exception->getMessage()
            );
        }
    }
}