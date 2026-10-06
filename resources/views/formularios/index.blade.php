@extends('layouts.app')

@section('title', 'Formularios clínicos | NutriCitas')

@section('page-title', 'Formularios clínicos')

@section('page-subtitle', 'Consulta el historial clínico y seguimiento nutricional de los pacientes.')

@section('page-actions')

<a
    href="{{ route('formularios.create') }}"
    class="btn btn-primary"
>
    <span class="icon">
        <svg viewBox="0 0 24 24">
            <path d="M12 5v14"></path>
            <path d="M5 12h14"></path>
        </svg>
    </span>

    Nuevo formulario
</a>

@endsection

@section('content')

<form
    action="{{ route('formularios.index') }}"
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
            placeholder="Paciente o número de expediente..."
        >

    </div>

    <button
        type="submit"
        class="btn btn-primary"
    >
        Buscar
    </button>

    <a
        href="{{ route('formularios.index') }}"
        class="btn btn-secondary"
    >
        Limpiar
    </a>

</form>

<div class="table-card">

    @if($formularios->isEmpty())

        <div class="empty-state">

            <div class="empty-icon">
                <span class="icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M6 2h9l4 4v16H6z"></path>
                        <path d="M14 2v5h5"></path>
                    </svg>
                </span>
            </div>

            <h3>
                No hay formularios clínicos
            </h3>

            <p>
                Cuando registres una consulta clínica
                aparecerá en este apartado.
            </p>

        </div>

    @else

        <div class="table-responsive">

            <table class="data-table">

                <thead>
                <tr>
                    <th>Expediente</th>
                    <th>Paciente</th>
                    <th>Fecha</th>
                    <th>Peso</th>
                    <th>IMC</th>
                    <th>Acciones</th>
                </tr>
                </thead>

                <tbody>

                @foreach($formularios as $formulario)

                    <tr>

                        <td>
                            <span class="table-primary">
                                {{ $formulario->numero_expediente }}
                            </span>
                        </td>

                        <td>
                            {{ $formulario->nombre }}

                            <span class="table-secondary">
                                {{ $formulario->cliente?->correo }}
                            </span>
                        </td>

                        <td>
                            {{ $formulario->fecha_consulta->format('d/m/Y') }}
                        </td>

                        <td>
                            {{ $formulario->peso
                                ? $formulario->peso . ' kg'
                                : '—'
                            }}
                        </td>

                        <td>
                            {{ $formulario->imc ?? '—' }}
                        </td>

                        <td>

                            <div class="table-actions">

                                <a
                                    href="{{ route(
                                        'formularios.show',
                                        $formulario
                                    ) }}"
                                    class="btn btn-secondary btn-small"
                                >
                                    Ver
                                </a>

                                <a
                                    href="{{ route(
                                        'formularios.edit',
                                        $formulario
                                    ) }}"
                                    class="btn btn-secondary btn-small"
                                >
                                    Editar
                                </a>

                                <form
                                    action="{{ route(
                                        'formularios.destroy',
                                        $formulario
                                    ) }}"
                                    method="POST"
                                    data-confirm="¿Deseas eliminar este formulario clínico?"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-small"
                                    >
                                        Eliminar
                                    </button>
                                </form>

                            </div>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

        <div class="pagination-wrapper">
            {{ $formularios->links() }}
        </div>

    @endif

</div>

@endsection