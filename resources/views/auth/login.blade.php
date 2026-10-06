<!DOCTYPE html>
<html
    lang="es"
    data-theme="light"
>

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        Inicio de sesión | NutriCitas
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body>

<div class="login-page">

    <aside class="login-aside">

        <a
            href="{{ route('inicio') }}"
            class="login-brand"
        >
            <span class="brand-symbol">
                <span class="icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 21C8 17 5 13.5 5 9a7 7 0 0 1 14 0c0 4.5-3 8-7 12Z"></path>
                        <path d="M9 10c1.5-3 4-4 7-4-1 3-3 5-7 5"></path>
                    </svg>
                </span>
            </span>

            NutriCitas
        </a>

        <div class="login-aside-content">

            <h1>
                Gestión sencilla para tu consultorio.
            </h1>

            <p>
                Administra citas, consulta tu calendario y registra
                la información clínica de tus pacientes desde un
                mismo lugar.
            </p>

        </div>

    </aside>

    <main class="login-main">

        <div class="login-wrapper">

            <div class="login-top">

                <button
                    type="button"
                    class="btn-icon"
                    data-theme-toggle
                    aria-label="Cambiar tema"
                >
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="4"></circle>
                            <path d="M12 2v2"></path>
                            <path d="M12 20v2"></path>
                            <path d="m4.93 4.93 1.41 1.41"></path>
                            <path d="m17.66 17.66 1.41 1.41"></path>
                            <path d="M2 12h2"></path>
                            <path d="M20 12h2"></path>
                            <path d="m6.34 17.66-1.41 1.41"></path>
                            <path d="m19.07 4.93-1.41 1.41"></path>
                        </svg>
                    </span>
                </button>

            </div>

            <div class="login-heading">

                <p class="section-eyebrow">
                    Área administrativa
                </p>

                <h2>
                    Inicio de sesión
                </h2>

                <p>
                    Acceso exclusivo para el nutriólogo
                    administrador del consultorio.
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

            <form
                action="{{ route('login.procesar') }}"
                method="POST"
                class="login-form"
            >
                @csrf

                <div class="form-group">

                    <label
                        for="correo"
                        class="form-label"
                    >
                        Correo electrónico
                    </label>

                    <input
                        type="email"
                        id="correo"
                        name="correo"
                        class="form-control"
                        value="{{ old('correo') }}"
                        placeholder="correo@consultorio.com"
                        autocomplete="email"
                        required
                        autofocus
                    >

                    @error('correo')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <div class="form-group">

                    <label
                        for="password"
                        class="form-label"
                    >
                        Contraseña
                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder="Ingresa tu contraseña"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            data-password-toggle="#password"
                            aria-label="Mostrar contraseña"
                        >
                            <span class="icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"></path>
                                    <circle cx="12" cy="12" r="2.5"></circle>
                                </svg>
                            </span>
                        </button>

                    </div>

                    @error('password')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <button
                    type="submit"
                    class="btn btn-primary w-full"
                >
                    Iniciar sesión

                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M5 12h14"></path>
                            <path d="m14 7 5 5-5 5"></path>
                        </svg>
                    </span>
                </button>

            </form>

            <div
                class="text-center"
                style="margin-top: 25px;"
            >
                <a
                    href="{{ route('inicio') }}"
                    class="text-muted"
                >
                    Volver al sitio público
                </a>
            </div>

        </div>

    </main>

</div>

</body>
</html>