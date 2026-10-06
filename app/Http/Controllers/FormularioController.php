<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Formulario;
use App\Services\FormularioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FormularioController extends Controller
{
    public function __construct(
        private readonly FormularioService $formularioService
    ) {
    }

    public function index(Request $request): View
    {
        $query = Formulario::query()
            ->with([
                'cliente',
                'nutriologo',
            ]);

        if ($request->filled('buscar')) {
            $buscar = trim(
                $request->input('buscar')
            );

            $query->where(function ($q) use ($buscar) {
                $q->where(
                    'numero_expediente',
                    'like',
                    "%{$buscar}%"
                )
                ->orWhere(
                    'nombre',
                    'like',
                    "%{$buscar}%"
                );
            });
        }

        $formularios = $query
            ->orderByDesc('fecha_consulta')
            ->orderByDesc('id_formulario')
            ->paginate(10)
            ->withQueryString();

        return view(
            'formularios.index',
            compact('formularios')
        );
    }

    public function create(
        Request $request
    ): View {
        $clientes = Cliente::query()
            ->orderBy('nombre')
            ->orderBy('apellido')
            ->get();

        $citas = Cita::query()
            ->with('cliente')
            ->whereIn(
                'estado',
                [
                    'PENDIENTE',
                    'CONFIRMADA',
                    'COMPLETADA',
                ]
            )
            ->orderByDesc('dia')
            ->get();

        $clienteSeleccionado =
            $request->integer('cliente') ?: null;

        $citaSeleccionada =
            $request->integer('cita') ?: null;

        return view(
            'formularios.create',
            compact(
                'clientes',
                'citas',
                'clienteSeleccionado',
                'citaSeleccionada'
            )
        );
    }

    public function store(
        Request $request
    ): RedirectResponse {
        $datos = $this->validarFormulario(
            $request
        );

        $datos['id_nutriologo'] =
            session('nutriologo_id');

        $formulario =
            $this->formularioService
                ->crearFormulario($datos);

        return redirect()
            ->route(
                'formularios.show',
                $formulario
            )
            ->with(
                'success',
                'El formulario clínico fue registrado correctamente.'
            );
    }

    public function show(
        Formulario $formulario
    ): View {
        $formulario->load([
            'cliente',
            'nutriologo',
            'cita',
        ]);

        return view(
            'formularios.show',
            compact('formulario')
        );
    }

    public function edit(
        Formulario $formulario
    ): View {
        $clientes = Cliente::query()
            ->orderBy('nombre')
            ->orderBy('apellido')
            ->get();

        $citas = Cita::query()
            ->orderByDesc('dia')
            ->get();

        return view(
            'formularios.edit',
            compact(
                'formulario',
                'clientes',
                'citas'
            )
        );
    }

    public function update(
        Request $request,
        Formulario $formulario
    ): RedirectResponse {
        $datos = $this->validarFormulario(
            $request
        );

        $datos['id_nutriologo'] =
            session('nutriologo_id');

        $this->formularioService
            ->actualizarFormulario(
                $formulario,
                $datos
            );

        return redirect()
            ->route(
                'formularios.show',
                $formulario
            )
            ->with(
                'success',
                'El formulario clínico fue actualizado correctamente.'
            );
    }

    public function destroy(
        Formulario $formulario
    ): RedirectResponse {
        $formulario->delete();

        return redirect()
            ->route('formularios.index')
            ->with(
                'success',
                'El formulario clínico fue eliminado correctamente.'
            );
    }

    private function validarFormulario(
        Request $request
    ): array {
        return $request->validate([
            'id_cliente' => [
                'required',
                'integer',
                'exists:clientes,id_cliente',
            ],

            'id_cita' => [
                'nullable',
                'integer',
                'exists:citas,id_cita',
            ],

            'nombre' => [
                'required',
                'string',
                'max:200',
            ],

            'peso' => [
                'nullable',
                'numeric',
                'min:1',
                'max:999.99',
            ],

            'estatura' => [
                'nullable',
                'numeric',
                'min:0.5',
                'max:3',
            ],

            'porcentaje_grasa' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],

            'contacto' => [
                'nullable',
                'string',
                'max:150',
            ],

            'antecedentes' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'fecha_nacimiento' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],

            'motivo_consulta' => [
                'required',
                'string',
                'max:3000',
            ],

            'circunferencia_cintura' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999.99',
            ],

            'circunferencia_cadera' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999.99',
            ],

            'masa_muscular' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999.99',
            ],

            'agua_corporal' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],

            'alergias' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'medicamentos' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'habitos_alimenticios' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'actividad_fisica' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'diagnostico' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'plan_nutricional' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'observaciones' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'fecha_consulta' => [
                'required',
                'date',
            ],
        ], [
            'id_cliente.required' =>
                'Selecciona un cliente.',

            'id_cliente.exists' =>
                'El cliente seleccionado no existe.',

            'nombre.required' =>
                'El nombre del paciente es obligatorio.',

            'motivo_consulta.required' =>
                'El motivo de consulta es obligatorio.',

            'fecha_consulta.required' =>
                'La fecha de consulta es obligatoria.',
        ]);
    }
}