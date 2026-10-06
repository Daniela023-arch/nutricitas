@extends('layouts.app')

@section('title', 'Expediente clínico | NutriCitas')

@section('page-title', 'Expediente clínico')

@section(
    'page-subtitle',
    'Información y evaluación nutricional registrada durante la consulta.'
)

@section('page-actions')

<a
    href="{{ route('formularios.index') }}"
    class="btn btn-secondary"
>
    Volver
</a>

<a
    href="{{ route('formularios.edit', $formulario) }}"
    class="btn btn-primary"
>
    <span class="icon">
        <svg viewBox="0 0 24 24">
            <path d="M12 20h9"></path>
            <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z"></path>
        </svg>
    </span>

    Editar
</a>

@endsection

@section('content')

<section class="patient-header">

    <div class="patient-avatar">
        {{ strtoupper(substr($formulario->nombre, 0, 1)) }}
    </div>

    <div class="patient-info">

        <h2>
            {{ $formulario->nombre }}
        </h2>

        <p>
            Expediente:
            <strong>
                {{ $formulario->numero_expediente }}
            </strong>
        </p>

        <p>
            Consulta del
            {{ $formulario->fecha_consulta->format('d/m/Y') }}
        </p>

    </div>

</section>

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

        <h2>
            Información general
        </h2>
    </div>

    <div class="form-section-body">

        <div class="detail-grid">

            <div class="detail-item">
                <div class="detail-label">
                    Número de expediente
                </div>

                <div class="detail-value">
                    {{ $formulario->numero_expediente }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">
                    Nombre
                </div>

                <div class="detail-value">
                    {{ $formulario->nombre }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">
                    Contacto
                </div>

                <div class="detail-value">
                    {{ $formulario->contacto ?: 'No registrado' }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">
                    Fecha de nacimiento
                </div>

                <div class="detail-value">
                    {{ $formulario->fecha_nacimiento
                        ? $formulario->fecha_nacimiento->format('d/m/Y')
                        : 'No registrada'
                    }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">
                    Edad
                </div>

                <div class="detail-value">
                    {{ $formulario->edad !== null
                        ? $formulario->edad . ' años'
                        : 'No registrada'
                    }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">
                    Fecha de consulta
                </div>

                <div class="detail-value">
                    {{ $formulario->fecha_consulta->format('d/m/Y') }}
                </div>
            </div>

        </div>

    </div>

</section>

<br>

<section class="form-section">

    <div class="form-section-header">
        <div class="form-section-icon">
            <span class="icon">
                <svg viewBox="0 0 24 24">
                    <path d="M3 3v18h18"></path>
                    <path d="m7 16 4-5 4 3 5-7"></path>
                </svg>
            </span>
        </div>

        <h2>
            Composición corporal
        </h2>
    </div>

    <div class="form-section-body">

        <div class="detail-grid">

            <div class="detail-item">
                <div class="detail-label">
                    Peso
                </div>

                <div class="detail-value">
                    {{ $formulario->peso
                        ? $formulario->peso . ' kg'
                        : 'No registrado'
                    }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">
                    Estatura
                </div>

                <div class="detail-value">
                    {{ $formulario->estatura
                        ? $formulario->estatura . ' m'
                        : 'No registrada'
                    }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">
                    IMC
                </div>

                <div class="detail-value">
                    {{ $formulario->imc ?? 'No registrado' }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">
                    Porcentaje de grasa
                </div>

                <div class="detail-value">
                    {{ $formulario->porcentaje_grasa !== null
                        ? $formulario->porcentaje_grasa . ' %'
                        : 'No registrado'
                    }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">
                    Masa muscular
                </div>

                <div class="detail-value">
                    {{ $formulario->masa_muscular ?? 'No registrada' }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">
                    Agua corporal
                </div>

                <div class="detail-value">
                    {{ $formulario->agua_corporal !== null
                        ? $formulario->agua_corporal . ' %'
                        : 'No registrada'
                    }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">
                    Circunferencia de cintura
                </div>

                <div class="detail-value">
                    {{ $formulario->circunferencia_cintura !== null
                        ? $formulario->circunferencia_cintura . ' cm'
                        : 'No registrada'
                    }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">
                    Circunferencia de cadera
                </div>

                <div class="detail-value">
                    {{ $formulario->circunferencia_cadera !== null
                        ? $formulario->circunferencia_cadera . ' cm'
                        : 'No registrada'
                    }}
                </div>
            </div>

        </div>

    </div>

</section>

<br>

<section class="form-section">

    <div class="form-section-header">
        <div class="form-section-icon">
            <span class="icon">
                <svg viewBox="0 0 24 24">
                    <path d="M9 3h6"></path>
                    <rect x="5" y="4" width="14" height="18" rx="2"></rect>
                    <path d="M9 10h6"></path>
                </svg>
            </span>
        </div>

        <h2>
            Evaluación clínica
        </h2>
    </div>

    <div class="form-section-body">

        @php
            $informacionClinica = [
                'Motivo de consulta' => $formulario->motivo_consulta,
                'Antecedentes' => $formulario->antecedentes,
                'Alergias' => $formulario->alergias,
                'Medicamentos' => $formulario->medicamentos,
                'Hábitos alimenticios' => $formulario->habitos_alimenticios,
                'Actividad física' => $formulario->actividad_fisica,
                'Diagnóstico / evaluación nutricional' => $formulario->diagnostico,
                'Plan nutricional' => $formulario->plan_nutricional,
                'Observaciones' => $formulario->observaciones,
            ];
        @endphp

        <div style="display: grid; gap: 14px;">

            @foreach($informacionClinica as $titulo => $contenido)

                <div class="detail-item">

                    <div class="detail-label">
                        {{ $titulo }}
                    </div>

                    <div
                        class="detail-value"
                        style="white-space: pre-line;"
                    >{{ $contenido ?: 'No registrado' }}</div>

                </div>

            @endforeach

        </div>

    </div>

</section>

@if($formulario->cita)

    <br>

    <section class="form-section">

        <div class="form-section-header">

            <div class="form-section-icon">
                <span class="icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M8 2v4"></path>
                        <path d="M16 2v4"></path>
                        <rect x="3" y="5" width="18" height="16" rx="2"></rect>
                        <path d="M3 10h18"></path>
                    </svg>
                </span>
            </div>

            <h2>
                Cita relacionada
            </h2>

        </div>

        <div class="form-section-body">

            <div class="detail-grid">

                <div class="detail-item">
                    <div class="detail-label">
                        Fecha
                    </div>

                    <div class="detail-value">
                        {{ $formulario->cita->dia->format('d/m/Y') }}
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">
                        Hora
                    </div>

                    <div class="detail-value">
                        {{ substr($formulario->cita->hora, 0, 5) }}
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">
                        Estado
                    </div>

                    <div class="detail-value">
                        <span
                            class="badge badge-{{ strtolower($formulario->cita->estado) }}"
                        >
                            {{ $formulario->cita->estado }}
                        </span>
                    </div>
                </div>

            </div>

        </div>

    </section>

@endif

@endsection