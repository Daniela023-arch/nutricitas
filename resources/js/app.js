/* =========================================================
   NUTRICITAS
   JavaScript global
   ========================================================= */

document.addEventListener('DOMContentLoaded', () => {
    iniciarTema();
    iniciarSidebar();
    iniciarMenuPublico();
    iniciarPasswordToggle();
    iniciarConfirmaciones();
    iniciarFormularioClinico();
    iniciarCalendario();
});

/* =========================================================
   MODO CLARO / OSCURO
   ========================================================= */

function iniciarTema() {
    const html = document.documentElement;

    const botones = document.querySelectorAll(
        '[data-theme-toggle]'
    );

    const temaGuardado =
        localStorage.getItem('nutricitas-theme');

    if (
        temaGuardado === 'dark' ||
        temaGuardado === 'light'
    ) {
        html.dataset.theme = temaGuardado;
    } else {
        const sistemaOscuro =
            window.matchMedia(
                '(prefers-color-scheme: dark)'
            ).matches;

        html.dataset.theme =
            sistemaOscuro ? 'dark' : 'light';
    }

    actualizarIconosTema();

    botones.forEach((boton) => {
        boton.addEventListener('click', () => {
            const nuevoTema =
                html.dataset.theme === 'dark'
                    ? 'light'
                    : 'dark';

            html.dataset.theme = nuevoTema;

            localStorage.setItem(
                'nutricitas-theme',
                nuevoTema
            );

            actualizarIconosTema();
        });
    });
}

function actualizarIconosTema() {
    const tema =
        document.documentElement.dataset.theme;

    document
        .querySelectorAll('[data-theme-icon]')
        .forEach((elemento) => {
            elemento.dataset.themeIcon = tema;
        });
}

/* =========================================================
   SIDEBAR
   ========================================================= */

function iniciarSidebar() {
    const sidebar =
        document.querySelector('[data-sidebar]');

    const boton =
        document.querySelector('[data-sidebar-toggle]');

    const overlay =
        document.querySelector('[data-sidebar-overlay]');

    if (!sidebar || !boton) {
        return;
    }

    boton.addEventListener('click', () => {
        sidebar.classList.toggle('open');

        if (overlay) {
            overlay.classList.toggle('active');
        }
    });

    if (overlay) {
        overlay.addEventListener('click', () => {
            cerrarSidebar();
        });
    }

    document
        .querySelectorAll('[data-sidebar] a')
        .forEach((enlace) => {
            enlace.addEventListener('click', () => {
                if (window.innerWidth <= 900) {
                    cerrarSidebar();
                }
            });
        });

    function cerrarSidebar() {
        sidebar.classList.remove('open');

        if (overlay) {
            overlay.classList.remove('active');
        }
    }
}

/* =========================================================
   MENÚ PÚBLICO RESPONSIVE
   ========================================================= */

function iniciarMenuPublico() {
    const boton =
        document.querySelector('[data-public-menu]');

    const menu =
        document.querySelector('[data-public-nav]');

    if (!boton || !menu) {
        return;
    }

    boton.addEventListener('click', () => {
        menu.classList.toggle('open');
    });

    menu.querySelectorAll('a').forEach((enlace) => {
        enlace.addEventListener('click', () => {
            menu.classList.remove('open');
        });
    });
}

/* =========================================================
   MOSTRAR / OCULTAR CONTRASEÑA
   ========================================================= */

function iniciarPasswordToggle() {
    document
        .querySelectorAll('[data-password-toggle]')
        .forEach((boton) => {
            boton.addEventListener('click', () => {
                const selector =
                    boton.dataset.passwordToggle;

                const input =
                    document.querySelector(selector);

                if (!input) {
                    return;
                }

                const mostrando =
                    input.type === 'text';

                input.type =
                    mostrando ? 'password' : 'text';

                boton.setAttribute(
                    'aria-label',
                    mostrando
                        ? 'Mostrar contraseña'
                        : 'Ocultar contraseña'
                );
            });
        });
}

/* =========================================================
   CONFIRMACIONES
   ========================================================= */

function iniciarConfirmaciones() {
    document
        .querySelectorAll('[data-confirm]')
        .forEach((formulario) => {
            formulario.addEventListener(
                'submit',
                (evento) => {
                    const mensaje =
                        formulario.dataset.confirm ||
                        '¿Deseas continuar?';

                    if (!window.confirm(mensaje)) {
                        evento.preventDefault();
                    }
                }
            );
        });
}

/* =========================================================
   FORMULARIO CLÍNICO
   ========================================================= */

function iniciarFormularioClinico() {
    const peso =
        document.querySelector('[data-peso]');

    const estatura =
        document.querySelector('[data-estatura]');

    const imc =
        document.querySelector('[data-imc]');

    const fechaNacimiento =
        document.querySelector(
            '[data-fecha-nacimiento]'
        );

    const edad =
        document.querySelector('[data-edad]');

    if (peso && estatura && imc) {
        const calcular = () => {
            const pesoValor =
                parseFloat(peso.value);

            const estaturaValor =
                parseFloat(estatura.value);

            if (
                Number.isFinite(pesoValor) &&
                Number.isFinite(estaturaValor) &&
                pesoValor > 0 &&
                estaturaValor > 0
            ) {
                const resultado =
                    pesoValor /
                    (estaturaValor * estaturaValor);

                imc.value =
                    resultado.toFixed(2);
            } else {
                imc.value = '';
            }
        };

        peso.addEventListener(
            'input',
            calcular
        );

        estatura.addEventListener(
            'input',
            calcular
        );

        calcular();
    }

    if (fechaNacimiento && edad) {
        const calcularEdad = () => {
            if (!fechaNacimiento.value) {
                edad.value = '';
                return;
            }

            const nacimiento =
                new Date(
                    fechaNacimiento.value +
                    'T00:00:00'
                );

            const hoy = new Date();

            let resultado =
                hoy.getFullYear() -
                nacimiento.getFullYear();

            const diferenciaMes =
                hoy.getMonth() -
                nacimiento.getMonth();

            if (
                diferenciaMes < 0 ||
                (
                    diferenciaMes === 0 &&
                    hoy.getDate() <
                    nacimiento.getDate()
                )
            ) {
                resultado--;
            }

            edad.value =
                resultado >= 0
                    ? resultado
                    : '';
        };

        fechaNacimiento.addEventListener(
            'change',
            calcularEdad
        );

        calcularEdad();
    }
}

/* =========================================================
   CALENDARIO
   ========================================================= */

function iniciarCalendario() {
    const contenedor =
        document.querySelector(
            '[data-calendar]'
        );

    if (!contenedor) {
        return;
    }

    const endpoint =
        contenedor.dataset.calendarUrl;

    if (!endpoint) {
        return;
    }

    let fechaActual = new Date();

    fechaActual = new Date(
        fechaActual.getFullYear(),
        fechaActual.getMonth(),
        1
    );

    let eventos = [];

    const titulo =
        document.querySelector(
            '[data-calendar-title]'
        );

    const grid =
        document.querySelector(
            '[data-calendar-grid]'
        );

    const anterior =
        document.querySelector(
            '[data-calendar-prev]'
        );

    const siguiente =
        document.querySelector(
            '[data-calendar-next]'
        );

    const hoy =
        document.querySelector(
            '[data-calendar-today]'
        );

    const agenda =
        document.querySelector(
            '[data-calendar-agenda]'
        );

    if (!grid) {
        return;
    }

    cargarEventos();

    if (anterior) {
        anterior.addEventListener(
            'click',
            () => {
                fechaActual.setMonth(
                    fechaActual.getMonth() - 1
                );

                renderizarCalendario();
            }
        );
    }

    if (siguiente) {
        siguiente.addEventListener(
            'click',
            () => {
                fechaActual.setMonth(
                    fechaActual.getMonth() + 1
                );

                renderizarCalendario();
            }
        );
    }

    if (hoy) {
        hoy.addEventListener(
            'click',
            () => {
                const ahora = new Date();

                fechaActual = new Date(
                    ahora.getFullYear(),
                    ahora.getMonth(),
                    1
                );

                renderizarCalendario();

                mostrarAgenda(
                    formatearFecha(ahora)
                );
            }
        );
    }

    async function cargarEventos() {
        try {
            const respuesta =
                await fetch(endpoint, {
                    headers: {
                        Accept: 'application/json'
                    }
                });

            if (!respuesta.ok) {
                throw new Error(
                    'No fue posible cargar las citas.'
                );
            }

            eventos =
                await respuesta.json();

            renderizarCalendario();

            mostrarAgenda(
                formatearFecha(new Date())
            );
        } catch (error) {
            grid.innerHTML = `
                <div class="alert alert-error"
                     style="grid-column: 1 / -1;">
                    No fue posible cargar el calendario.
                </div>
            `;
        }
    }

    function renderizarCalendario() {
        grid.innerHTML = '';

        const year =
            fechaActual.getFullYear();

        const month =
            fechaActual.getMonth();

        if (titulo) {
            titulo.textContent =
                new Intl.DateTimeFormat(
                    'es-MX',
                    {
                        month: 'long',
                        year: 'numeric'
                    }
                ).format(fechaActual);
        }

        const primerDia =
            new Date(year, month, 1);

        const ultimoDia =
            new Date(year, month + 1, 0);

        /*
         * Convertimos domingo=0 de JS
         * a lunes=0 para el calendario.
         */
        let inicio =
            primerDia.getDay() - 1;

        if (inicio < 0) {
            inicio = 6;
        }

        const totalDias =
            ultimoDia.getDate();

        const mesAnterior =
            new Date(year, month, 0)
                .getDate();

        const totalCeldas =
            Math.ceil(
                (inicio + totalDias) / 7
            ) * 7;

        for (
            let indice = 0;
            indice < totalCeldas;
            indice++
        ) {
            let numero;
            let fechaCelda;
            let muted = false;

            if (indice < inicio) {
                numero =
                    mesAnterior -
                    inicio +
                    indice +
                    1;

                fechaCelda =
                    new Date(
                        year,
                        month - 1,
                        numero
                    );

                muted = true;
            } else if (
                indice >= inicio + totalDias
            ) {
                numero =
                    indice -
                    inicio -
                    totalDias +
                    1;

                fechaCelda =
                    new Date(
                        year,
                        month + 1,
                        numero
                    );

                muted = true;
            } else {
                numero =
                    indice - inicio + 1;

                fechaCelda =
                    new Date(
                        year,
                        month,
                        numero
                    );
            }

            const fechaTexto =
                formatearFecha(fechaCelda);

            const citasDia =
                eventos.filter(
                    (evento) =>
                        evento.dia === fechaTexto
                );

            const celda =
                document.createElement('div');

            celda.className =
                'calendar-day';

            if (muted) {
                celda.classList.add('muted');
            }

            if (
                fechaTexto ===
                formatearFecha(new Date())
            ) {
                celda.classList.add('today');
            }

            const numeroElemento =
                document.createElement('div');

            numeroElemento.className =
                'calendar-day-number';

            numeroElemento.textContent =
                numero;

            celda.appendChild(
                numeroElemento
            );

            citasDia
                .slice(0, 3)
                .forEach((evento) => {
                    const boton =
                        document.createElement(
                            'button'
                        );

                    boton.type = 'button';

                    boton.className =
                        'calendar-event';

                    boton.textContent =
                        `${evento.hora} ${evento.nombre}`;

                    boton.title =
                        `${evento.hora} - ${evento.nombre}`;

                    boton.addEventListener(
                        'click',
                        (event) => {
                            event.stopPropagation();

                            mostrarAgenda(
                                evento.dia
                            );
                        }
                    );

                    celda.appendChild(
                        boton
                    );
                });

            if (citasDia.length > 3) {
                const mas =
                    document.createElement(
                        'small'
                    );

                mas.className =
                    'text-muted';

                mas.textContent =
                    `+${citasDia.length - 3} más`;

                celda.appendChild(mas);
            }

            celda.addEventListener(
                'click',
                () => {
                    mostrarAgenda(
                        fechaTexto
                    );
                }
            );

            grid.appendChild(celda);
        }
    }

    function mostrarAgenda(fecha) {
        if (!agenda) {
            return;
        }

        const citas =
            eventos
                .filter(
                    (evento) =>
                        evento.dia === fecha
                )
                .sort(
                    (a, b) =>
                        a.hora.localeCompare(
                            b.hora
                        )
                );

        const fechaObjeto =
            new Date(
                fecha + 'T00:00:00'
            );

        const fechaBonita =
            new Intl.DateTimeFormat(
                'es-MX',
                {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long'
                }
            ).format(fechaObjeto);

        agenda.innerHTML = '';

        const encabezado =
            document.createElement('h3');

        encabezado.textContent =
            fechaBonita;

        agenda.appendChild(encabezado);

        if (citas.length === 0) {
            const vacio =
                document.createElement('p');

            vacio.className =
                'text-muted';

            vacio.textContent =
                'No hay citas programadas para este día.';

            agenda.appendChild(vacio);

            return;
        }

        citas.forEach((evento) => {
            const item =
                document.createElement('div');

            item.className =
                'agenda-item';

            const hora =
                document.createElement('div');

            hora.className =
                'agenda-time';

            hora.textContent =
                `${evento.hora} · ${evento.estado}`;

            const nombre =
                document.createElement('div');

            nombre.className =
                'agenda-name';

            nombre.textContent =
                evento.nombre;

            const motivo =
                document.createElement('div');

            motivo.className =
                'agenda-motive';

            motivo.textContent =
                evento.motivo;

            item.append(
                hora,
                nombre,
                motivo
            );

            agenda.appendChild(item);
        });
    }

    function formatearFecha(fecha) {
        const year =
            fecha.getFullYear();

        const month =
            String(
                fecha.getMonth() + 1
            ).padStart(2, '0');

        const day =
            String(
                fecha.getDate()
            ).padStart(2, '0');

        return `${year}-${month}-${day}`;
    }
}