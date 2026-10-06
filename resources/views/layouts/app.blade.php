<!DOCTYPE html>
<html lang="es" data-theme="light">

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

    <title>@yield('title', 'NutriCitas')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Bungee&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body>

<div class="app-shell">

    <aside
        class="sidebar"
        data-sidebar
    >

        <div class="sidebar-header">

            <a
                href="{{ route('dashboard') }}"
                class="brand"
            >
                <span class="brand-symbol">
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 21C8 17 5 13.5 5 9a7 7 0 0 1 14 0c0 4.5-3 8-7 12Z"></path>
                            <path d="M9 10c1.5-3 4-4 7-4-1 3-3 5-7 5"></path>
                        </svg>
                    </span>
                </span>

                <span>NutriCitas</span>
            </a>

            <button
                type="button"
                class="sidebar-close"
                data-sidebar-close
                aria-label="Cerrar menú"
            >
                <span class="icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                    </svg>
                </span>
            </button>

        </div>

        <div class="sidebar-profile">

            <div class="sidebar-avatar">
                {{ strtoupper(
                    substr(
                        session('nutriologo_nombre', 'N'),
                        0,
                        1
                    )
                ) }}
            </div>

            <div>
                <strong>
                    {{ session(
                        'nutriologo_nombre',
                        'Nutriólogo'
                    ) }}
                </strong>

                <span>
                    Superadministrador
                </span>
            </div>

        </div>

        <nav class="sidebar-nav">

            <p class="sidebar-label">
                Principal
            </p>

            <a
                href="{{ route('dashboard') }}"
                class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
            >
                <span class="icon">
                    <svg viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                    </svg>
                </span>

                Dashboard
            </a>

            <a
                href="{{ route('citas.index') }}"
                class="sidebar-link {{ request()->routeIs('citas.index') ? 'active' : '' }}"
            >
                <span class="icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M8 2v4"></path>
                        <path d="M16 2v4"></path>
                        <rect x="3" y="5" width="18" height="16" rx="2"></rect>
                        <path d="M3 10h18"></path>
                    </svg>
                </span>

                Citas
            </a>

            <a
                href="{{ route('citas.calendario') }}"
                class="sidebar-link {{ request()->routeIs('citas.calendario*') ? 'active' : '' }}"
            >
                <span class="icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M8 2v4"></path>
                        <path d="M16 2v4"></path>
                        <rect x="3" y="5" width="18" height="16" rx="2"></rect>
                        <path d="M3 10h18"></path>
                        <path d="M8 14h.01"></path>
                        <path d="M12 14h.01"></path>
                        <path d="M16 14h.01"></path>
                    </svg>
                </span>

                Calendario
            </a>

            <p class="sidebar-label">
                Pacientes
            </p>

            <a
                href="{{ route('clientes.index') }}"
                class="sidebar-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}"
            >
                <span class="icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                    </svg>
                </span>

                Clientes
            </a>

            <a
                href="{{ route('formularios.index') }}"
                class="sidebar-link {{ request()->routeIs('formularios.*') ? 'active' : '' }}"
            >
                <span class="icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M6 2h9l4 4v16H6z"></path>
                        <path d="M14 2v5h5"></path>
                        <path d="M9 13h6"></path>
                        <path d="M9 17h6"></path>
                    </svg>
                </span>

                Formularios
            </a>

        </nav>

        <div class="sidebar-footer">

            <a
                href="{{ route('inicio') }}"
                class="sidebar-link"
                target="_blank"
            >
                <span class="icon">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9"></circle>
                        <path d="M3 12h18"></path>
                        <path d="M12 3a15 15 0 0 1 0 18"></path>
                        <path d="M12 3a15 15 0 0 0 0 18"></path>
                    </svg>
                </span>

                Ver sitio público
            </a>

            <form
                action="{{ route('logout') }}"
                method="POST"
            >
                @csrf

                <button
                    type="submit"
                    class="sidebar-link sidebar-button"
                >
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M10 17l5-5-5-5"></path>
                            <path d="M15 12H3"></path>
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        </svg>
                    </span>

                    Cerrar sesión
                </button>
            </form>

        </div>

    </aside>

    <div
        class="sidebar-overlay"
        data-sidebar-overlay
    ></div>

    <div class="app-content">

        <header class="topbar">

            <div class="topbar-left">

                <button
                    type="button"
                    class="btn-icon mobile-sidebar-button"
                    data-sidebar-open
                    aria-label="Abrir menú"
                >
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 6h16"></path>
                            <path d="M4 12h16"></path>
                            <path d="M4 18h16"></path>
                        </svg>
                    </span>
                </button>

                <div>
                    <h1>
                        @yield('page-title', 'NutriCitas')
                    </h1>

                    <p>
                        @yield('page-subtitle')
                    </p>
                </div>

            </div>

            <div class="topbar-actions">

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
                        </svg>
                    </span>
                </button>

                @yield('page-actions')

            </div>

        </header>

        <main class="main-content">

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

            @if($errors->any())
                <div class="alert alert-error">
                    <strong>
                        Revisa la información ingresada.
                    </strong>
                </div>
            @endif

            @yield('content')

        </main>

    </div>

</div>

</body>
</html>