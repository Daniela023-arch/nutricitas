@extends('layouts.app')

@section('title', 'Calendario | NutriCitas')

@section('page-title', 'Calendario')

@section('page-subtitle', 'Visualiza las citas programadas por día y mes.')

@section('page-actions')

<a
    href="{{ route('citas.index') }}"
    class="btn btn-secondary"
>
    Ver historial
</a>

@endsection

@section('content')

<div
    class="calendar-layout"
    data-calendar
    data-calendar-url="{{ route('citas.calendario.eventos') }}"
>

    <section class="calendar-card">

        <div class="calendar-header">

            <h2
                class="calendar-title"
                data-calendar-title
            >
                Calendario
            </h2>

            <div class="calendar-controls">

                <button
                    type="button"
                    class="btn btn-secondary btn-small"
                    data-calendar-prev
                    aria-label="Mes anterior"
                >
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <path d="m15 18-6-6 6-6"></path>
                        </svg>
                    </span>
                </button>

                <button
                    type="button"
                    class="btn btn-secondary btn-small"
                    data-calendar-today
                >
                    Hoy
                </button>

                <button
                    type="button"
                    class="btn btn-secondary btn-small"
                    data-calendar-next
                    aria-label="Mes siguiente"
                >
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <path d="m9 18 6-6-6-6"></path>
                        </svg>
                    </span>
                </button>

            </div>

        </div>

        <div class="calendar-weekdays">
            <div class="calendar-weekday">Lun</div>
            <div class="calendar-weekday">Mar</div>
            <div class="calendar-weekday">Mié</div>
            <div class="calendar-weekday">Jue</div>
            <div class="calendar-weekday">Vie</div>
            <div class="calendar-weekday">Sáb</div>
            <div class="calendar-weekday">Dom</div>
        </div>

        <div
            class="calendar-grid"
            data-calendar-grid
        ></div>

    </section>

    <aside class="calendar-sidebar">

        <section
            class="calendar-agenda"
            data-calendar-agenda
        >
            <h3>
                Agenda del día
            </h3>

            <p class="text-muted">
                Selecciona un día para consultar
                las citas programadas.
            </p>
        </section>

        <section class="calendar-agenda">

            <h3>
                Estados
            </h3>

            <div
                class="status-list"
                style="gap: 10px;"
            >

                <div>
                    <span class="badge badge-pendiente">
                        Pendiente
                    </span>
                </div>

                <div>
                    <span class="badge badge-confirmada">
                        Confirmada
                    </span>
                </div>

                <div>
                    <span class="badge badge-completada">
                        Completada
                    </span>
                </div>

            </div>

        </section>

    </aside>

</div>

@endsection