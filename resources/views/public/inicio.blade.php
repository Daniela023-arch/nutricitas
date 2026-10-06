@extends('layouts.public')

@section('title', 'Inicio | NutriCitas')

@section('content')

<section class="hero">
    <div class="public-container">
        <div class="hero-grid">

            <div>
                <span class="hero-eyebrow">
                    Nutrición personalizada
                </span>

                <h1 class="hero-title">
                    Cuida tu salud,
                    <span>mejora tu alimentación.</span>
                </h1>

                <p class="hero-description">
                    Atención nutricional personalizada enfocada en tus
                    objetivos, hábitos y necesidades. Agenda tu consulta
                    de manera sencilla y comienza a trabajar en una
                    alimentación más saludable.
                </p>

                <div class="hero-actions">
                    <a
                        href="{{ route('citas.publicas') }}"
                        class="btn btn-primary"
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

                        Agendar cita
                    </a>

                    <a
                        href="#consultorio"
                        class="btn btn-secondary"
                    >
                        Conocer consultorio
                    </a>
                </div>
            </div>

            <div class="hero-panel">
                <div class="hero-panel-content">

                    <p class="section-eyebrow">
                        Consulta nutricional
                    </p>

                    <h2 class="hero-panel-title">
                        Un plan pensado para ti
                    </h2>

                    <p>
                        Evaluación nutricional, seguimiento de progreso,
                        orientación alimentaria y estrategias adaptadas
                        a tus objetivos.
                    </p>

                </div>
            </div>

        </div>
    </div>
</section>

<section
    class="info-section"
    id="consultorio"
>
    <div class="public-container">

        <div class="section-heading">
            <p class="section-eyebrow">
                Consultorio
            </p>

            <h2 class="section-title">
                Información de contacto
            </h2>

            <p class="section-description">
                Ponte en contacto con el consultorio o agenda directamente
                una cita desde nuestro sitio.
            </p>
        </div>

        <div class="info-grid">

            <article class="info-card">

                <div class="info-card-icon">
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"></path>
                            <circle cx="12" cy="10" r="2.5"></circle>
                        </svg>
                    </span>
                </div>

                <h3>Ubicación</h3>

                <p>
                    Dirección del consultorio
                </p>

                <p>
                    Estado de México, México
                </p>

            </article>

            <article class="info-card">

                <div class="info-card-icon">
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.33 1.78.62 2.63a2 2 0 0 1-.45 2.11L8 9.73a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.85.29 1.73.5 2.63.62A2 2 0 0 1 22 16.92Z"></path>
                        </svg>
                    </span>
                </div>

                <h3>Teléfono</h3>

                <p>
                    {{ $nutriologo?->telefono ?? '55 5555 5555' }}
                </p>

                <p>
                    Atención con previa cita.
                </p>

            </article>

            <article class="info-card">

                <div class="info-card-icon">
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                            <path d="m3 7 9 6 9-6"></path>
                        </svg>
                    </span>
                </div>

                <h3>Correo</h3>

                <p>
                    {{ $nutriologo?->correo ?? 'contacto@nutricitas.com' }}
                </p>

                <p>
                    Escríbenos para más información.
                </p>

            </article>

        </div>

    </div>
</section>

<section class="info-section">
    <div class="public-container">

        <div class="section-heading">
            <p class="section-eyebrow">
                Servicios
            </p>

            <h2 class="section-title">
                Acompañamiento nutricional
            </h2>
        </div>

        <div class="info-grid">

            <article class="info-card">
                <div class="info-card-icon">
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M9 11 12 14 22 4"></path>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                        </svg>
                    </span>
                </div>

                <h3>Evaluación nutricional</h3>

                <p>
                    Análisis inicial para conocer tu situación actual
                    y establecer objetivos.
                </p>
            </article>

            <article class="info-card">
                <div class="info-card-icon">
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M3 3v18h18"></path>
                            <path d="m7 16 4-5 4 3 5-7"></path>
                        </svg>
                    </span>
                </div>

                <h3>Seguimiento</h3>

                <p>
                    Registro de peso, IMC, composición corporal
                    y evolución durante las consultas.
                </p>
            </article>

            <article class="info-card">
                <div class="info-card-icon">
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 22c4-2 7-6 7-11V5l-7-3-7 3v6c0 5 3 9 7 11Z"></path>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>
                    </span>
                </div>

                <h3>Plan personalizado</h3>

                <p>
                    Recomendaciones adaptadas a tus necesidades,
                    objetivos y estilo de vida.
                </p>
            </article>

        </div>

    </div>
</section>

<section class="info-section">
    <div class="public-container">

        <div class="card">
            <div class="card-body">

                <div class="section-heading">
                    <p class="section-eyebrow">
                        Redes sociales
                    </p>

                    <h2 class="section-title">
                        Encuéntranos también en redes
                    </h2>
                </div>

                <div class="social-links">

                    <a
                        href="#"
                        class="social-link"
                        aria-label="Instagram"
                    >
                        <span class="icon">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="3" width="18" height="18" rx="5"></rect>
                                <circle cx="12" cy="12" r="4"></circle>
                                <path d="M17.5 6.5h.01"></path>
                            </svg>
                        </span>

                        Instagram
                    </a>

                    <a
                        href="#"
                        class="social-link"
                        aria-label="Facebook"
                    >
                        <span class="icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3Z"></path>
                            </svg>
                        </span>

                        Facebook
                    </a>

                    <a
                        href="#"
                        class="social-link"
                        aria-label="WhatsApp"
                    >
                        <span class="icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8A8.5 8.5 0 0 1 12.5 20a8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7A8.38 8.38 0 0 1 4 11.5 8.5 8.5 0 0 1 8.7 3.9 8.38 8.38 0 0 1 12.5 3h.5a8.48 8.48 0 0 1 8 8Z"></path>
                            </svg>
                        </span>

                        WhatsApp
                    </a>

                </div>

            </div>
        </div>

    </div>
</section>

@endsection