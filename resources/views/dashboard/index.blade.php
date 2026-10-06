@extends('layouts.app')

@section('title', 'Dashboard | NutriCitas')

@section('page-title', 'Dashboard')

@section('page-subtitle', 'Resumen general del consultorio y próximas citas.')

@section('content')

<div class="stats-grid">

    <article class="stat-card">
        <div class="stat-top">
            <div class="stat-icon">
                <span class="icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M8 2v4"></path>
                        <path d="M16 2v4"></path>
                        <rect x="3" y="5" width="18" height="16" rx="2"></rect>
                        <path d="M3 10h18"></path>
                    </svg>
                </span>
            </div>
        </div>

        <div class="stat-label">
            Citas de hoy
        </div>

        <p class="stat-number">
            {{ $citasHoy }}
        </p>
    </article>

    <article class="stat-card">
        <div class="stat-top">
            <div class="stat-icon">
                <span class="icon">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9"></circle>
                        <path d="M12 7v5l3 2"></path>
                    </svg>
                </span>
            </div>
        </div>

        <div class="stat-label">
            Citas pendientes
        </div>

        <p class="stat-number">
            {{ $citasPendientes }}
        </p>
    </article>

    <article class="stat-card">
        <div class="stat-top">
            <div class="stat-icon">
                <span class="icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                    </svg>
                </span>
            </div>
        </div>

        <div class="stat-label">
            Clientes
        </div>

        <p class="stat-number">
            {{ $totalClientes }}
        </p>
    </article>

    <article class="stat-card">
        <div class="stat-top">
            <div class="stat-icon">
                <span class="icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M6 2h9l4 4v16H6z"></path>
                        <path d="M14 2v5h5"></path>
                        <path d="M9 13h6"></path>
                        <path d="M9 17h6"></path>
                    </svg>
                </span>
            </div>
        </div>

        <div class="stat-label">
            Formularios clínicos
        </div>

        <p class="stat-number">
            {{ $totalFormularios }}
        </p>
    </article>

</div>

<div class="dashboard-grid">

    <section class="card">

        <div class="card-header">

            <h2 class="card-title">
                Próximas citas
            </h2>

            <a
                href="{{ route('citas.index') }}"
                class="btn btn-secondary btn-small"
            >
                Ver todas
            </a>

        </div>

        @if($proximasCitas->isEmpty())

            <div class="empty-state">

                <div class="empty-icon">
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M8 2v4"></path>
                            <path d="M16 2v4"></path>
                            <rect x="3" y="5" width="18" height="16" rx="2"></rect>
                            <path d="M3 10h18"></path>
                        </svg>
                    </span>
                </div>

                <h3>
                    No hay próximas citas
                </h3>

                <p>
                    Las nuevas citas aparecerán aquí
                    automáticamente.
                </p>

            </div>

        @else

            <div class="table-responsive">

                <table class="data-table">

                    <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                    </tr>
                    </thead>

                    <tbody>

                    @foreach($proximasCitas as $cita)

                        <tr>

                            <td>
                                <span class="table-primary">
                                    {{ $cita->nombre }}
                                    {{ $cita->apellido }}
                                </span>

                                <span class="table-secondary">
                                    {{ $cita->correo }}
                                </span>
                            </td>

                            <td>
                                {{ $cita->dia->format('d/m/Y') }}
                            </td>

                            <td>
                                {{ substr($cita->hora, 0, 5) }}
                            </td>

                            <td>
                                <span
                                    class="badge badge-{{ strtolower($cita->estado) }}"
                                >
                                    {{ $cita->estado }}
                                </span>
                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        @endif

    </section>

    <section class="card">

        <div class="card-header">
            <h2 class="card-title">
                Estado de citas
            </h2>
        </div>

        <div class="card-body">

            @php
                $maximo = max(
                    1,
                    array_sum($citasPorEstado)
                );
            @endphp

            <div class="status-list">

                <div class="status-row">

                    <div class="status-row-top">
                        <span>Pendientes</span>
                        <strong>
                            {{ $citasPorEstado['pendientes'] }}
                        </strong>
                    </div>

                    <div class="status-track">
                        <div
                            class="status-bar"
                            style="width: {{ ($citasPorEstado['pendientes'] / $maximo) * 100 }}%"
                        ></div>
                    </div>

                </div>

                <div class="status-row">

                    <div class="status-row-top">
                        <span>Confirmadas</span>
                        <strong>
                            {{ $citasPorEstado['confirmadas'] }}
                        </strong>
                    </div>

                    <div class="status-track">
                        <div
                            class="status-bar"
                            style="width: {{ ($citasPorEstado['confirmadas'] / $maximo) * 100 }}%"
                        ></div>
                    </div>

                </div>

                <div class="status-row">

                    <div class="status-row-top">
                        <span>Completadas</span>
                        <strong>
                            {{ $citasPorEstado['completadas'] }}
                        </strong>
                    </div>

                    <div class="status-track">
                        <div
                            class="status-bar"
                            style="width: {{ ($citasPorEstado['completadas'] / $maximo) * 100 }}%"
                        ></div>
                    </div>

                </div>

                <div class="status-row">

                    <div class="status-row-top">
                        <span>Canceladas</span>
                        <strong>
                            {{ $citasPorEstado['canceladas'] }}
                        </strong>
                    </div>

                    <div class="status-track">
                        <div
                            class="status-bar"
                            style="width: {{ ($citasPorEstado['canceladas'] / $maximo) * 100 }}%"
                        ></div>
                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection