@extends('layouts.app')

@section('title', 'Editar formulario | NutriCitas')

@section('page-title', 'Editar formulario clínico')

@section(
    'page-subtitle',
    'Actualiza la información clínica registrada durante la consulta.'
)

@section('page-actions')

<a
    href="{{ route('formularios.show', $formulario) }}"
    class="btn btn-secondary"
>
    Volver al expediente
</a>

@endsection

@section('content')

@if($errors->any())
    <div class="alert alert-error">
        Revisa los campos marcados antes de guardar los cambios.
    </div>
@endif

<form
    action="{{ route('formularios.update', $formulario) }}"
    method="POST"
    class="clinical-form"
>
    @csrf
    @method('PUT')

    <section class="form-section">

        <div class="form-section-header">

            <div class="form-section-icon">
                <span class="icon">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4"></circle>
                        <path d="M4 21a8 8 0 0 1 16 0"></path>
                    </svg>
                </span>
            </div>

            <div>
                <h2>Datos del paciente</h2>

                <small class="text-muted">
                    Expediente:
                    {{ $formulario->numero_expediente }}
                </small>
            </div>

        </div>

        <div class="form-section-body">

            <div class="form-grid">

                <div class="form-group">

                    <label
                        for="id_cliente"
                        class="form-label"
                    >
                        Cliente
                        <span class="required">*</span>
                    </label>

                    <select
                        name="id_cliente"
                        id="id_cliente"
                        class="form-select"
                        required
                    >

                        @foreach($clientes as $cliente)

                            <option
                                value="{{ $cliente->id_cliente }}"
                                @selected(
                                    old(
                                        'id_cliente',
                                        $formulario->id_cliente
                                    ) == $cliente->id_cliente
                                )
                            >
                                {{ $cliente->nombre }}
                                {{ $cliente->apellido }}

                                @if($cliente->correo)
                                    — {{ $cliente->correo }}
                                @endif
                            </option>

                        @endforeach

                    </select>

                    @error('id_cliente')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <div class="form-group">

                    <label
                        for="id_cita"
                        class="form-label"
                    >
                        Cita relacionada
                    </label>

                    <select
                        name="id_cita"
                        id="id_cita"
                        class="form-select"
                    >

                        <option value="">
                            Sin cita relacionada
                        </option>

                        @foreach($citas as $cita)

                            <option
                                value="{{ $cita->id_cita }}"
                                @selected(
                                    old(
                                        'id_cita',
                                        $formulario->id_cita
                                    ) == $cita->id_cita
                                )
                            >
                                {{ $cita->dia->format('d/m/Y') }}
                                · {{ substr($cita->hora, 0, 5) }}
                                · {{ $cita->nombre }}
                                {{ $cita->apellido }}
                            </option>

                        @endforeach

                    </select>

                    @error('id_cita')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <div class="form-group">

                    <label
                        for="nombre"
                        class="form-label"
                    >
                        Nombre
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        name="nombre"
                        id="nombre"
                        class="form-control"
                        value="{{ old(
                            'nombre',
                            $formulario->nombre
                        ) }}"
                        maxlength="200"
                        required
                    >

                    @error('nombre')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <div class="form-group">

                    <label
                        for="contacto"
                        class="form-label"
                    >
                        Contacto
                    </label>

                    <input
                        type="text"
                        name="contacto"
                        id="contacto"
                        class="form-control"
                        value="{{ old(
                            'contacto',
                            $formulario->contacto
                        ) }}"
                        maxlength="150"
                    >

                    @error('contacto')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <div class="form-group">

                    <label
                        for="fecha_nacimiento"
                        class="form-label"
                    >
                        Fecha de nacimiento
                    </label>

                    <input
                        type="date"
                        name="fecha_nacimiento"
                        id="fecha_nacimiento"
                        class="form-control"
                        value="{{ old(
                            'fecha_nacimiento',
                            $formulario->fecha_nacimiento?->format('Y-m-d')
                        ) }}"
                        max="{{ now()->format('Y-m-d') }}"
                        data-fecha-nacimiento
                    >

                    @error('fecha_nacimiento')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <div class="form-group">

                    <label
                        for="edad"
                        class="form-label"
                    >
                        Edad
                    </label>

                    <input
                        type="text"
                        id="edad"
                        class="form-control calculated-field"
                        value="{{ $formulario->edad }}"
                        data-edad
                        readonly
                    >

                </div>

            </div>

        </div>

    </section>

    <section class="form-section">

        <div class="form-section-header">

            <div class="form-section-icon">
                <span class="icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M4 19V5"></path>
                        <path d="M4 19h16"></path>
                        <path d="m7 15 4-5 3 3 5-7"></path>
                    </svg>
                </span>
            </div>

            <div>
                <h2>Composición corporal</h2>
                <small class="text-muted">
                    Mediciones del paciente.
                </small>
            </div>

        </div>

        <div class="form-section-body">

            <div class="form-grid">

                <div class="form-group">

                    <label
                        for="peso"
                        class="form-label"
                    >
                        Peso (kg)
                    </label>

                    <input
                        type="number"
                        name="peso"
                        id="peso"
                        class="form-control"
                        value="{{ old('peso', $formulario->peso) }}"
                        min="1"
                        max="999.99"
                        step="0.01"
                        data-peso
                    >

                    @error('peso')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <div class="form-group">

                    <label
                        for="estatura"
                        class="form-label"
                    >
                        Estatura (m)
                    </label>

                    <input
                        type="number"
                        name="estatura"
                        id="estatura"
                        class="form-control"
                        value="{{ old(
                            'estatura',
                            $formulario->estatura
                        ) }}"
                        min="0.5"
                        max="3"
                        step="0.01"
                        data-estatura
                    >

                    @error('estatura')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <div class="form-group">

                    <label
                        for="imc"
                        class="form-label"
                    >
                        IMC
                    </label>

                    <input
                        type="text"
                        id="imc"
                        class="form-control calculated-field"
                        value="{{ $formulario->imc }}"
                        data-imc
                        readonly
                    >

                </div>

                <div class="form-group">

                    <label
                        for="porcentaje_grasa"
                        class="form-label"
                    >
                        Porcentaje de grasa (%)
                    </label>

                    <input
                        type="number"
                        name="porcentaje_grasa"
                        id="porcentaje_grasa"
                        class="form-control"
                        value="{{ old(
                            'porcentaje_grasa',
                            $formulario->porcentaje_grasa
                        ) }}"
                        min="0"
                        max="100"
                        step="0.01"
                    >

                    @error('porcentaje_grasa')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <div class="form-group">

                    <label
                        for="masa_muscular"
                        class="form-label"
                    >
                        Masa muscular
                    </label>

                    <input
                        type="number"
                        name="masa_muscular"
                        id="masa_muscular"
                        class="form-control"
                        value="{{ old(
                            'masa_muscular',
                            $formulario->masa_muscular
                        ) }}"
                        min="0"
                        max="999.99"
                        step="0.01"
                    >

                    @error('masa_muscular')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <div class="form-group">

                    <label
                        for="agua_corporal"
                        class="form-label"
                    >
                        Agua corporal (%)
                    </label>

                    <input
                        type="number"
                        name="agua_corporal"
                        id="agua_corporal"
                        class="form-control"
                        value="{{ old(
                            'agua_corporal',
                            $formulario->agua_corporal
                        ) }}"
                        min="0"
                        max="100"
                        step="0.01"
                    >

                    @error('agua_corporal')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <div class="form-group">

                    <label
                        for="circunferencia_cintura"
                        class="form-label"
                    >
                        Circunferencia cintura (cm)
                    </label>

                    <input
                        type="number"
                        name="circunferencia_cintura"
                        id="circunferencia_cintura"
                        class="form-control"
                        value="{{ old(
                            'circunferencia_cintura',
                            $formulario->circunferencia_cintura
                        ) }}"
                        min="0"
                        max="999.99"
                        step="0.01"
                    >

                    @error('circunferencia_cintura')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <div class="form-group">

                    <label
                        for="circunferencia_cadera"
                        class="form-label"
                    >
                        Circunferencia cadera (cm)
                    </label>

                    <input
                        type="number"
                        name="circunferencia_cadera"
                        id="circunferencia_cadera"
                        class="form-control"
                        value="{{ old(
                            'circunferencia_cadera',
                            $formulario->circunferencia_cadera
                        ) }}"
                        min="0"
                        max="999.99"
                        step="0.01"
                    >

                    @error('circunferencia_cadera')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

            </div>

        </div>

    </section>

    <section class="form-section">

        <div class="form-section-header">
            <div class="form-section-icon">
                <span class="icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M9 3h6"></path>
                        <rect x="5" y="4" width="14" height="18" rx="2"></rect>
                        <path d="M9 10h6"></path>
                        <path d="M9 14h6"></path>
                    </svg>
                </span>
            </div>

            <div>
                <h2>Información clínica</h2>
            </div>
        </div>

        <div class="form-section-body">

            <div class="form-grid">

                <div class="form-group">

                    <label
                        for="fecha_consulta"
                        class="form-label"
                    >
                        Fecha de consulta
                        <span class="required">*</span>
                    </label>

                    <input
                        type="date"
                        name="fecha_consulta"
                        id="fecha_consulta"
                        class="form-control"
                        value="{{ old(
                            'fecha_consulta',
                            $formulario->fecha_consulta->format('Y-m-d')
                        ) }}"
                        required
                    >

                    @error('fecha_consulta')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                @php
                    $areas = [
                        [
                            'motivo_consulta',
                            'Motivo de consulta',
                            3000,
                            true
                        ],
                        [
                            'antecedentes',
                            'Antecedentes',
                            5000,
                            false
                        ],
                        [
                            'alergias',
                            'Alergias',
                            3000,
                            false
                        ],
                        [
                            'medicamentos',
                            'Medicamentos',
                            3000,
                            false
                        ],
                        [
                            'habitos_alimenticios',
                            'Hábitos alimenticios',
                            5000,
                            false
                        ],
                        [
                            'actividad_fisica',
                            'Actividad física',
                            3000,
                            false
                        ],
                        [
                            'diagnostico',
                            'Diagnóstico / evaluación nutricional',
                            5000,
                            false
                        ],
                        [
                            'plan_nutricional',
                            'Plan nutricional',
                            5000,
                            false
                        ],
                        [
                            'observaciones',
                            'Observaciones',
                            5000,
                            false
                        ],
                    ];
                @endphp

                @foreach($areas as [$campo, $titulo, $maximo, $obligatorio])

                    <div class="form-group full">

                        <label
                            for="{{ $campo }}"
                            class="form-label"
                        >
                            {{ $titulo }}

                            @if($obligatorio)
                                <span class="required">*</span>
                            @endif
                        </label>

                        <textarea
                            name="{{ $campo }}"
                            id="{{ $campo }}"
                            class="form-textarea"
                            maxlength="{{ $maximo }}"
                            @required($obligatorio)
                        >{{ old($campo, $formulario->{$campo}) }}</textarea>

                        @error($campo)
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                @endforeach

            </div>

        </div>

    </section>

    <div class="form-actions">

        <a
            href="{{ route('formularios.show', $formulario) }}"
            class="btn btn-secondary"
        >
            Cancelar
        </a>

        <button
            type="submit"
            class="btn btn-primary"
        >
            Guardar cambios
        </button>

    </div>

</form>

@endsection