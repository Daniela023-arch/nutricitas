@extends('layouts.app')

@section('title', 'Clientes | NutriCitas')

@section('page-title', 'Clientes')

@section('page-subtitle', 'Pacientes registrados a partir de las citas del consultorio.')

@section('content')

<form
    action="{{ route('clientes.index') }}"
    method="GET"
    class="filters"
>

    <div class="filter-group filter-group-search">

        <label
            for="buscar"
            class="form-label"
        >
            Buscar cliente
        </label>

        <input
            type="search"
            id="buscar"
            name="buscar"
            class="form-control"
            value="{{ request('buscar') }}"
            placeholder="Nombre, correo o teléfono..."
        >

    </div>

    <button
        type="submit"
        class="btn btn-primary"
    >
        Buscar
    </button>

    <a
        href="{{ route('clientes.index') }}"
        class="btn btn-secondary"
    >
        Limpiar
    </a>

</form>

<div class="table-card">

    @if($clientes->isEmpty())

        <div class="empty-state">

            <div class="empty-icon">
                <span class="icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                    </svg>
                </span>
            </div>

            <h3>
                No hay clientes
            </h3>

            <p>
                Los clientes aparecerán automáticamente
                cuando registren una cita.
            </p>

        </div>

    @else

        <div class="table-responsive">

            <table class="data-table">

                <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Contacto</th>
                    <th>Citas</th>
                    <th>Consultas clínicas</th>
                    <th>Acciones</th>
                </tr>
                </thead>

                <tbody>

                @foreach($clientes as $cliente)

                    <tr>

                        <td>
                            <span class="table-primary">
                                {{ $cliente->nombre }}
                                {{ $cliente->apellido }}
                            </span>

                            @if($cliente->fecha_nacimiento)
                                <span class="table-secondary">
                                    {{ $cliente->fecha_nacimiento->format('d/m/Y') }}
                                </span>
                            @endif
                        </td>

                        <td>
                            {{ $cliente->correo ?? 'Sin correo' }}

                            <span class="table-secondary">
                                {{ $cliente->telefono ?? 'Sin teléfono' }}
                            </span>
                        </td>

                        <td>
                            {{ $cliente->citas_count }}
                        </td>

                        <td>
                            {{ $cliente->formularios_count }}
                        </td>

                        <td>

                            <a
                                href="{{ route(
                                    'formularios.create',
                                    ['cliente' => $cliente->id_cliente]
                                ) }}"
                                class="btn btn-primary btn-small"
                            >
                                Nuevo formulario
                            </a>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

        <div class="pagination-wrapper">
            {{ $clientes->links() }}
        </div>

    @endif

</div>

@endsection