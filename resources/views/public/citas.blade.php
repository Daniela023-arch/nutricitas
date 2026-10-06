@extends('layouts.public')

@section('title', 'Agendar cita | NutriCitas')

@section('content')

<section class="appointment-section">

    <div class="public-container">

        <div class="section-heading">

            <p class="section-eyebrow">
                Agenda
            </p>

            <h1 class="section-title">
                Agenda tu consulta
            </h1>

            <p class="section-description">
                Completa tus datos y selecciona el día y horario
                en el que deseas acudir al consultorio.
            </p>

        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="appointment-layout">

            <aside class="appointment-info">

                <p class="section-eyebrow">
                    Antes de reservar
                </p>

                <h2>
                    Tu consulta comienza aquí
                </h2>

                <p>
                    Selecciona una fecha disponible y proporciona
                    tus datos de contacto. El sistema verificará
                    automáticamente que el horario no se encuentre
                    ocupado.
                </p>

                <div class="appointment-notes">

                    <div class="appointment-note">

                        <span class="icon">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9"></circle>
                                <path d="M12 7v5l3 2"></path>
                            </svg>
                        </span>

                        <span>
                            No es posible registrar dos citas
                            en el mismo horario.
                        </span>

                    </div>

                    <div class="appointment-note">

                        <span class="icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M8 2v4"></path>
                                <path d="M16 2v4"></path>
                                <rect x="3" y="5" width="18" height="16" rx="2"></rect>
                                <path d="M3 10h18"></path>
                            </svg>
                        </span>

                        <span>
                            Solo puedes seleccionar el día actual
                            o fechas posteriores.
                        </span>

                    </div>

                    <div class="appointment-note">

                        <span class="icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M4 4h16v16H4z"></path>
                                <path d="m4 7 8 6 8-6"></path>
                            </svg>
                        </span>

                        <span>
                            Verifica que tu correo electrónico
                            esté escrito correctamente.
                        </span>

                    </div>

                </div>

            </aside>

            <div class="appointment-form">

                <form
                    action="{{ route('citas.publicas.guardar') }}"
                    method="POST"
                >
                    @csrf

                    <div class="form-grid">

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
                                id="nombre"
                                name="nombre"
                                class="form-control"
                                value="{{ old('nombre') }}"
                                placeholder="Tu nombre"
                                maxlength="100"
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
                                for="apellido"
                                class="form-label"
                            >
                                Apellido
                                <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                id="apellido"
                                name="apellido"
                                class="form-control"
                                value="{{ old('apellido') }}"
                                placeholder="Tu apellido"
                                maxlength="100"
                                required
                            >

                            @error('apellido')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                        <div class="form-group">

                            <label
                                for="correo"
                                class="form-label"
                            >
                                Correo electrónico
                                <span class="required">*</span>
                            </label>

                            <input
                                type="email"
                                id="correo"
                                name="correo"
                                class="form-control"
                                value="{{ old('correo') }}"
                                placeholder="correo@ejemplo.com"
                                maxlength="150"
                                required
                            >

                            @error('correo')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                        <div class="form-group">

                            <label
                                for="telefono"
                                class="form-label"
                            >
                                Teléfono
                            </label>

                            <input
                                type="tel"
                                id="telefono"
                                name="telefono"
                                class="form-control"
                                value="{{ old('telefono') }}"
                                placeholder="55 1234 5678"
                                maxlength="20"
                            >

                            @error('telefono')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                        <div class="form-group">

                            <label
                                for="dia"
                                class="form-label"
                            >
                                Día
                                <span class="required">*</span>
                            </label>

                            <input
                                type="date"
                                id="dia"
                                name="dia"
                                class="form-control"
                                value="{{ old('dia') }}"
                                min="{{ now()->format('Y-m-d') }}"
                                required
                            >

                            @error('dia')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                        <div class="form-group">

                            <label
                                for="hora"
                                class="form-label"
                            >
                                Hora
                                <span class="required">*</span>
                            </label>

                            <input
                                type="time"
                                id="hora"
                                name="hora"
                                class="form-control"
                                value="{{ old('hora') }}"
                                required
                            >

                            @error('hora')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                        <div class="form-group full">

                            <label
                                for="motivo_consulta"
                                class="form-label"
                            >
                                Motivo de consulta
                                <span class="required">*</span>
                            </label>

                            <textarea
                                id="motivo_consulta"
                                name="motivo_consulta"
                                class="form-textarea"
                                maxlength="1500"
                                placeholder="Cuéntanos brevemente el motivo de tu consulta..."
                                required
                            >{{ old('motivo_consulta') }}</textarea>

                            @error('motivo_consulta')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>

                    <div class="form-actions">

                        <a
                            href="{{ route('inicio') }}"
                            class="btn btn-secondary"
                        >
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            <span class="icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M8 2v4"></path>
                                    <path d="M16 2v4"></path>
                                    <rect x="3" y="5" width="18" height="16" rx="2"></rect>
                                    <path d="M3 10h18"></path>
                                    <path d="m9 15 2 2 4-4"></path>
                                </svg>
                            </span>

                            Agendar cita
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</section>

@endsection