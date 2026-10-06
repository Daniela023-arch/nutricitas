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
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

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

<header class="public-header">

    <div class="public-container public-nav">

        <a
            href="{{ route('inicio') }}"
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
            class="mobile-menu-button"
            data-mobile-menu
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

        <nav
            class="public-navigation"
            data-mobile-navigation
        >
            <a
                href="{{ route('inicio') }}"
                class="{{ request()->routeIs('inicio') ? 'active' : '' }}"
            >
                Inicio
            </a>

            <a href="{{ route('inicio') }}#consultorio">
                Consultorio
            </a>

            <a
                href="{{ route('citas.publicas') }}"
                class="{{ request()->routeIs('citas.publicas') ? 'active' : '' }}"
            >
                Agendar cita
            </a>

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

            <a
                href="{{ route('login') }}"
                class="btn btn-secondary"
            >
                Acceso nutriólogo
            </a>
        </nav>

    </div>

</header>

<main>
    @yield('content')
</main>

<footer class="public-footer">

    <div class="public-container">

        <div class="footer-grid">

            <div>
                <a
                    href="{{ route('inicio') }}"
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

                <p class="footer-description">
                    Atención nutricional personalizada y
                    seguimiento profesional.
                </p>
            </div>

            <div>
                <h3>Navegación</h3>

                <div class="footer-links">
                    <a href="{{ route('inicio') }}">
                        Inicio
                    </a>

                    <a href="{{ route('citas.publicas') }}">
                        Agendar cita
                    </a>

                    <a href="{{ route('login') }}">
                        Acceso nutriólogo
                    </a>
                </div>
            </div>

            <div>
                <h3>Contacto</h3>

                <div class="footer-links">
                    <span>Atención con previa cita</span>
                    <span>Consultorio nutricional</span>
                </div>
            </div>

        </div>

        <div class="footer-bottom">
            <span>
                © {{ date('Y') }} NutriCitas
            </span>

            <span>
                Consultorio de nutrición
            </span>
        </div>

    </div>

</footer>

</body>
</html>