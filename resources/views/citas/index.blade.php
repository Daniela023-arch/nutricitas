@extends('layouts.app')

@section('title', 'Citas | NutriCitas')

@section('page-title', 'Gestión de citas')

@section('page-subtitle', 'Consulta, filtra y administra las citas realizadas por los clientes.')

@section('page-actions')

<a
    href="{{ route('citas.calendario') }}"
    class="btn btn-primary"
>
    <span class="icon">
        <svg viewBox="0 0 24 24">
            <path d="M8 2v4"></path>
            <path d="M16 2v4"></path>
            <rect x="3" y="5" width="18" height="16" rx="2"></rect>
            <path d="M3 10h18"></path>
        </svg>
    </span>

    Ver calendario
</a>

@endsection

@section('content')

<form
    action="{{ route('citas.index') }}"
    method="GET"
    class="filters"
>

    <div class="filter-group filter-group-search">

        <label
            for="buscar"
            class="form-label"
        >
            Buscar
        </label>

        <input
            type="search"
            id="buscar"
            name="buscar"
            class="form-control"
            value="{{ request('buscar') }}"
            placeholder="Nombre, apellido o correo..."
        >

    </div>

    <div class="filter-group">

        <label
            for="estado"
            class="form-label"
        >
            Estado
        </label>

        <select
            id="estado"
            name="estado"
            class="form-select"
        >
            <option value="">
                Todos
            </option>

            @foreach([
                'PENDIENTE',
                'CONFIRMADA',
                'COMPLETADA',
                'CANCELADA'
            ] as $estado)

                <option
                    value="{{ $estado }}"
                    @selected(request('estado') === $estado)
                >
                    {{ ucfirst(strtolower($estado)) }}
                </option>

            @endforeach

        </select>

    </div>

    <div class="filter-group">

        <label
            for="fecha"
            class="form-label"
        >
            Fecha
        </label>

        <input
            type="date"
            id="fecha"
            name="fecha"
            class="form-control"
            value="{{ request('fecha') }}"
        >

    </div>

    <button
        type="submit"
        class="btn btn-primary"
    >
        Filtrar
    </button>

    <a
        href="{{ route('citas.index') }}"
        class="btn btn-secondary"
    >
        Limpiar
    </a>

</form>

<div class="table-card">

    @if($citas->isEmpty())

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
                No encontramos citas
            </h3>

            <p>
                No existen citas que coincidan
                con los filtros seleccionados.
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
                    <th>Motivo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
                </thead>

                <tbody>

                @foreach($citas as $cita)

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
                            {{ \Illuminate\Support\Str::limit(
                                $cita->motivo_consulta,
                                45
                            ) }}
                        </td>

                        <td>
                            <span
                                class="badge badge-{{ strtolower($cita->estado) }}"
                            >
                                {{ $cita->estado }}
                            </span>
                        </td>

                        <td>

                            <div class="table-actions">

                                @if($cita->estado === 'PENDIENTE')

                                    <form
                                        action="{{ route('citas.estado', $cita) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <input
                                            type="hidden"
                                            name="estado"
                                            value="CONFIRMADA"
                                        >

                                        <button
                                            type="submit"
                                            class="btn btn-secondary btn-small"
                                        >
                                            Confirmar
                                        </button>
                                    </form>

                                @endif

                                @if(
                                    $cita->estado === 'CONFIRMADA'
                                    || $cita->estado === 'PENDIENTE'
                                )

                                    <form
                                        action="{{ route('citas.estado', $cita) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <input
                                            type="hidden"
                                            name="estado"
                                            value="COMPLETADA"
                                        >

                                        <button
                                            type="submit"
                                            class="btn btn-secondary btn-small"
                                        >
                                            Completar
                                        </button>
                                    </form>

                                @endif

                                @if($cita->estado !== 'CANCELADA')

                                    <form
                                        action="{{ route('citas.estado', $cita) }}"
                                        method="POST"
                                        data-confirm="¿Deseas cancelar esta cita?"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <input
                                            type="hidden"
                                            name="estado"
                                            value="CANCELADA"
                                        >

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-small"
                                        >
                                            Cancelar
                                        </button>
                                    </form>

                                @endif

                                @if(
                                    $cita->id_cliente
                                    && !$cita->formulario
                                )

                                    <a
                                        href="{{ route('formularios.create', [
                                            'cliente' => $cita->id_cliente,
                                            'cita' => $cita->id_cita
                                        ]) }}"
                                        class="btn btn-primary btn-small"
                                    >
                                        Formulario
                                    </a>

                                @elseif($cita->formulario)

                                    <a
                                        href="{{ route(
                                            'formularios.show',
                                            $cita->formulario
                                        ) }}"
                                        class="btn btn-secondary btn-small"
                                    >
                                        Expediente
                                    </a>

                                @endif

                            </div>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

        <div class="pagination-wrapper">
            {{ $citas->links() }}
        </div>

    @endif

</div>

@endsection