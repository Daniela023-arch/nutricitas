@extends('layouts.app')

@section('title', 'Nuevo formulario clínico | NutriCitas')

@section('page-title', 'Nuevo formulario clínico')

@section('page-subtitle', 'Registra la evaluación nutricional y la información clínica del paciente.')

@section('page-actions')
    <a
        href="{{ route('formularios.index') }}"
        class="btn btn-secondary"
    >
        Volver
    </a>
@endsection

@section('content')

    {{-- MENSAJES DE ERROR --}}
    @if ($errors->any())
        <div class="alert alert-error">
            <strong>No se pudo guardar el formulario.</strong>
            Revisa los campos marcados e inténtalo nuevamente.
        </div>
    @endif


    <form
        action="{{ route('formularios.store') }}"
        method="POST"
        class="clinical-form"
        id="clinicalForm"
    >
        @csrf


        {{-- =========================================================
             DATOS DEL PACIENTE
        ========================================================== --}}

        <section class="form-section">

            <div class="form-section-header">

                <div class="form-section-icon">
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="8" r="4"></circle>
                            <path d="M4 21a8 8 0 0 1 16 0"></path>
                        </svg>
                    </span>
                </div>

                <div>
                    <h2>Datos del paciente</h2>

                    <p class="text-muted">
                        Selecciona al cliente y registra su información general.
                    </p>
                </div>

            </div>


            <div class="form-section-body">

                <div class="form-grid">


                    {{-- CLIENTE --}}
                    <div class="form-group">

                        <label
                            for="id_cliente"
                            class="form-label"
                        >
                            Cliente
                            <span class="required">*</span>
                        </label>

                        <select
                            name="id_cliente"
                            id="id_cliente"
                            class="form-select"
                            required
                        >
                            <option value="">
                                Selecciona un cliente
                            </option>

                            @foreach ($clientes as $cliente)

                                <option
                                    value="{{ $cliente->id_cliente }}"
                                    data-nombre="{{ $cliente->nombre }} {{ $cliente->apellido }}"
                                    data-contacto="{{ $cliente->telefono ?: $cliente->correo }}"
                                    data-fecha-nacimiento="{{ $cliente->fecha_nacimiento?->format('Y-m-d') }}"
                                    @selected(
                                        old(
                                            'id_cliente',
                                            $clienteSeleccionado
                                        ) == $cliente->id_cliente
                                    )
                                >
                                    {{ $cliente->nombre }}
                                    {{ $cliente->apellido }}

                                    @if ($cliente->correo)
                                        — {{ $cliente->correo }}
                                    @endif
                                </option>

                            @endforeach
                        </select>

                        @error('id_cliente')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- CITA --}}
                    <div class="form-group">

                        <label
                            for="id_cita"
                            class="form-label"
                        >
                            Cita relacionada
                        </label>

                        <select
                            name="id_cita"
                            id="id_cita"
                            class="form-select"
                        >
                            <option value="">
                                Sin cita relacionada
                            </option>

                            @foreach ($citas as $cita)

                                <option
                                    value="{{ $cita->id_cita }}"
                                    data-cliente="{{ $cita->id_cliente }}"
                                    data-motivo="{{ $cita->motivo_consulta }}"
                                    @selected(
                                        old(
                                            'id_cita',
                                            $citaSeleccionada
                                        ) == $cita->id_cita
                                    )
                                >
                                    {{ $cita->dia->format('d/m/Y') }}
                                    ·
                                    {{ substr($cita->hora, 0, 5) }}
                                    ·
                                    {{ $cita->nombre }}
                                    {{ $cita->apellido }}
                                </option>

                            @endforeach
                        </select>

                        @error('id_cita')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- NOMBRE --}}
                    <div class="form-group">

                        <label
                            for="nombre"
                            class="form-label"
                        >
                            Nombre completo
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="nombre"
                            id="nombre"
                            class="form-control"
                            value="{{ old('nombre') }}"
                            maxlength="200"
                            placeholder="Nombre completo del paciente"
                            required
                        >

                        @error('nombre')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- CONTACTO --}}
                    <div class="form-group">

                        <label
                            for="contacto"
                            class="form-label"
                        >
                            Contacto
                        </label>

                        <input
                            type="text"
                            name="contacto"
                            id="contacto"
                            class="form-control"
                            value="{{ old('contacto') }}"
                            maxlength="150"
                            placeholder="Teléfono o correo electrónico"
                        >

                        @error('contacto')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- FECHA NACIMIENTO --}}
                    <div class="form-group">

                        <label
                            for="fecha_nacimiento"
                            class="form-label"
                        >
                            Fecha de nacimiento
                        </label>

                        <input
                            type="date"
                            name="fecha_nacimiento"
                            id="fecha_nacimiento"
                            class="form-control"
                            value="{{ old('fecha_nacimiento') }}"
                            max="{{ now()->format('Y-m-d') }}"
                            data-fecha-nacimiento
                        >

                        @error('fecha_nacimiento')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- EDAD --}}
                    <div class="form-group">

                        <label
                            for="edad_visual"
                            class="form-label"
                        >
                            Edad
                        </label>

                        <input
                            type="text"
                            id="edad_visual"
                            class="form-control calculated-field"
                            placeholder="Se calcula automáticamente"
                            data-edad
                            readonly
                        >

                        <span class="form-help">
                            Se calcula a partir de la fecha de nacimiento.
                        </span>

                    </div>

                </div>

            </div>

        </section>



        {{-- =========================================================
             COMPOSICIÓN CORPORAL
        ========================================================== --}}

        <section class="form-section">

            <div class="form-section-header">

                <div class="form-section-icon">
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 19V5"></path>
                            <path d="M4 19h16"></path>
                            <path d="m7 15 4-5 3 3 5-7"></path>
                        </svg>
                    </span>
                </div>

                <div>
                    <h2>Composición corporal</h2>

                    <p class="text-muted">
                        Registra las mediciones obtenidas durante la consulta.
                    </p>
                </div>

            </div>


            <div class="form-section-body">

                <div class="form-grid">


                    {{-- PESO --}}
                    <div class="form-group">

                        <label
                            for="peso"
                            class="form-label"
                        >
                            Peso
                        </label>

                        <div class="input-with-unit">

                            <input
                                type="number"
                                name="peso"
                                id="peso"
                                class="form-control"
                                value="{{ old('peso') }}"
                                min="1"
                                max="999.99"
                                step="0.01"
                                placeholder="70.50"
                                data-peso
                            >

                            <span>kg</span>

                        </div>

                        @error('peso')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- ESTATURA --}}
                    <div class="form-group">

                        <label
                            for="estatura"
                            class="form-label"
                        >
                            Estatura
                        </label>

                        <div class="input-with-unit">

                            <input
                                type="number"
                                name="estatura"
                                id="estatura"
                                class="form-control"
                                value="{{ old('estatura') }}"
                                min="0.50"
                                max="3"
                                step="0.01"
                                placeholder="1.70"
                                data-estatura
                            >

                            <span>m</span>

                        </div>

                        @error('estatura')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- IMC --}}
                    <div class="form-group">

                        <label
                            for="imc_visual"
                            class="form-label"
                        >
                            IMC
                        </label>

                        <input
                            type="text"
                            id="imc_visual"
                            class="form-control calculated-field"
                            placeholder="Se calcula automáticamente"
                            data-imc
                            readonly
                        >

                        <span class="form-help">
                            Peso dividido entre estatura al cuadrado.
                        </span>

                    </div>


                    {{-- PORCENTAJE DE GRASA --}}
                    <div class="form-group">

                        <label
                            for="porcentaje_grasa"
                            class="form-label"
                        >
                            Porcentaje de grasa
                        </label>

                        <div class="input-with-unit">

                            <input
                                type="number"
                                name="porcentaje_grasa"
                                id="porcentaje_grasa"
                                class="form-control"
                                value="{{ old('porcentaje_grasa') }}"
                                min="0"
                                max="100"
                                step="0.01"
                                placeholder="24.50"
                            >

                            <span>%</span>

                        </div>

                        @error('porcentaje_grasa')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- MASA MUSCULAR --}}
                    <div class="form-group">

                        <label
                            for="masa_muscular"
                            class="form-label"
                        >
                            Masa muscular
                        </label>

                        <div class="input-with-unit">

                            <input
                                type="number"
                                name="masa_muscular"
                                id="masa_muscular"
                                class="form-control"
                                value="{{ old('masa_muscular') }}"
                                min="0"
                                max="999.99"
                                step="0.01"
                                placeholder="42.50"
                            >

                            <span>kg</span>

                        </div>

                        @error('masa_muscular')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- AGUA CORPORAL --}}
                    <div class="form-group">

                        <label
                            for="agua_corporal"
                            class="form-label"
                        >
                            Agua corporal
                        </label>

                        <div class="input-with-unit">

                            <input
                                type="number"
                                name="agua_corporal"
                                id="agua_corporal"
                                class="form-control"
                                value="{{ old('agua_corporal') }}"
                                min="0"
                                max="100"
                                step="0.01"
                                placeholder="55.00"
                            >

                            <span>%</span>

                        </div>

                        @error('agua_corporal')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- CINTURA --}}
                    <div class="form-group">

                        <label
                            for="circunferencia_cintura"
                            class="form-label"
                        >
                            Circunferencia de cintura
                        </label>

                        <div class="input-with-unit">

                            <input
                                type="number"
                                name="circunferencia_cintura"
                                id="circunferencia_cintura"
                                class="form-control"
                                value="{{ old('circunferencia_cintura') }}"
                                min="0"
                                max="999.99"
                                step="0.01"
                                placeholder="80.00"
                            >

                            <span>cm</span>

                        </div>

                        @error('circunferencia_cintura')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- CADERA --}}
                    <div class="form-group">

                        <label
                            for="circunferencia_cadera"
                            class="form-label"
                        >
                            Circunferencia de cadera
                        </label>

                        <div class="input-with-unit">

                            <input
                                type="number"
                                name="circunferencia_cadera"
                                id="circunferencia_cadera"
                                class="form-control"
                                value="{{ old('circunferencia_cadera') }}"
                                min="0"
                                max="999.99"
                                step="0.01"
                                placeholder="95.00"
                            >

                            <span>cm</span>

                        </div>

                        @error('circunferencia_cadera')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                </div>

            </div>

        </section>



        {{-- =========================================================
             INFORMACIÓN CLÍNICA
        ========================================================== --}}

        <section class="form-section">

            <div class="form-section-header">

                <div class="form-section-icon">
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M9 3h6"></path>
                            <path d="M10 2h4a1 1 0 0 1 1 1v2H9V3a1 1 0 0 1 1-1Z"></path>
                            <rect
                                x="5"
                                y="4"
                                width="14"
                                height="18"
                                rx="2"
                            ></rect>
                            <path d="M9 10h6"></path>
                            <path d="M9 14h6"></path>
                        </svg>
                    </span>
                </div>

                <div>
                    <h2>Información clínica</h2>

                    <p class="text-muted">
                        Antecedentes, alergias y motivo de consulta.
                    </p>
                </div>

            </div>


            <div class="form-section-body">

                <div class="form-grid">


                    {{-- FECHA CONSULTA --}}
                    <div class="form-group">

                        <label
                            for="fecha_consulta"
                            class="form-label"
                        >
                            Fecha de consulta
                            <span class="required">*</span>
                        </label>

                        <input
                            type="date"
                            name="fecha_consulta"
                            id="fecha_consulta"
                            class="form-control"
                            value="{{ old(
                                'fecha_consulta',
                                now()->format('Y-m-d')
                            ) }}"
                            required
                        >

                        @error('fecha_consulta')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- MOTIVO --}}
                    <div class="form-group full">

                        <label
                            for="motivo_consulta"
                            class="form-label"
                        >
                            Motivo de consulta
                            <span class="required">*</span>
                        </label>

                        <textarea
                            name="motivo_consulta"
                            id="motivo_consulta"
                            class="form-textarea"
                            maxlength="3000"
                            rows="4"
                            placeholder="Describe el motivo principal de la consulta..."
                            required
                        >{{ old('motivo_consulta') }}</textarea>

                        @error('motivo_consulta')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- ANTECEDENTES --}}
                    <div class="form-group full">

                        <label
                            for="antecedentes"
                            class="form-label"
                        >
                            Antecedentes
                        </label>

                        <textarea
                            name="antecedentes"
                            id="antecedentes"
                            class="form-textarea"
                            maxlength="5000"
                            rows="5"
                            placeholder="Antecedentes personales, familiares y clínicos..."
                        >{{ old('antecedentes') }}</textarea>

                        @error('antecedentes')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- ALERGIAS --}}
                    <div class="form-group">

                        <label
                            for="alergias"
                            class="form-label"
                        >
                            Alergias
                        </label>

                        <textarea
                            name="alergias"
                            id="alergias"
                            class="form-textarea"
                            maxlength="3000"
                            rows="4"
                            placeholder="Alergias conocidas..."
                        >{{ old('alergias') }}</textarea>

                        @error('alergias')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- MEDICAMENTOS --}}
                    <div class="form-group">

                        <label
                            for="medicamentos"
                            class="form-label"
                        >
                            Medicamentos
                        </label>

                        <textarea
                            name="medicamentos"
                            id="medicamentos"
                            class="form-textarea"
                            maxlength="3000"
                            rows="4"
                            placeholder="Medicamentos que consume actualmente..."
                        >{{ old('medicamentos') }}</textarea>

                        @error('medicamentos')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                </div>

            </div>

        </section>



        {{-- =========================================================
             HÁBITOS Y ESTILO DE VIDA
        ========================================================== --}}

        <section class="form-section">

            <div class="form-section-header">

                <div class="form-section-icon">
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 22c4-2 7-6 7-11V5l-7-3-7 3v6c0 5 3 9 7 11Z"></path>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>
                    </span>
                </div>

                <div>
                    <h2>Hábitos y estilo de vida</h2>

                    <p class="text-muted">
                        Información sobre alimentación y actividad física.
                    </p>
                </div>

            </div>


            <div class="form-section-body">

                <div class="form-grid">


                    {{-- HÁBITOS ALIMENTICIOS --}}
                    <div class="form-group">

                        <label
                            for="habitos_alimenticios"
                            class="form-label"
                        >
                            Hábitos alimenticios
                        </label>

                        <textarea
                            name="habitos_alimenticios"
                            id="habitos_alimenticios"
                            class="form-textarea"
                            maxlength="5000"
                            rows="5"
                            placeholder="Horarios, cantidad de comidas, alimentos habituales..."
                        >{{ old('habitos_alimenticios') }}</textarea>

                        @error('habitos_alimenticios')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- ACTIVIDAD FÍSICA --}}
                    <div class="form-group">

                        <label
                            for="actividad_fisica"
                            class="form-label"
                        >
                            Actividad física
                        </label>

                        <textarea
                            name="actividad_fisica"
                            id="actividad_fisica"
                            class="form-textarea"
                            maxlength="3000"
                            rows="5"
                            placeholder="Tipo de ejercicio, frecuencia y duración..."
                        >{{ old('actividad_fisica') }}</textarea>

                        @error('actividad_fisica')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                </div>

            </div>

        </section>



        {{-- =========================================================
             EVALUACIÓN NUTRICIONAL
        ========================================================== --}}

        <section class="form-section">

            <div class="form-section-header">

                <div class="form-section-icon">
                    <span class="icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M3 3v18h18"></path>
                            <path d="m7 16 4-5 4 3 5-7"></path>
                        </svg>
                    </span>
                </div>

                <div>
                    <h2>Evaluación nutricional</h2>

                    <p class="text-muted">
                        Diagnóstico, plan nutricional y observaciones.
                    </p>
                </div>

            </div>


            <div class="form-section-body">

                <div class="form-grid">


                    {{-- DIAGNÓSTICO --}}
                    <div class="form-group full">

                        <label
                            for="diagnostico"
                            class="form-label"
                        >
                            Diagnóstico / evaluación nutricional
                        </label>

                        <textarea
                            name="diagnostico"
                            id="diagnostico"
                            class="form-textarea"
                            maxlength="5000"
                            rows="5"
                            placeholder="Escribe la evaluación nutricional del paciente..."
                        >{{ old('diagnostico') }}</textarea>

                        @error('diagnostico')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- PLAN NUTRICIONAL --}}
                    <div class="form-group full">

                        <label
                            for="plan_nutricional"
                            class="form-label"
                        >
                            Plan nutricional
                        </label>

                        <textarea
                            name="plan_nutricional"
                            id="plan_nutricional"
                            class="form-textarea"
                            maxlength="5000"
                            rows="6"
                            placeholder="Indicaciones, objetivos y recomendaciones nutricionales..."
                        >{{ old('plan_nutricional') }}</textarea>

                        @error('plan_nutricional')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- OBSERVACIONES --}}
                    <div class="form-group full">

                        <label
                            for="observaciones"
                            class="form-label"
                        >
                            Observaciones
                        </label>

                        <textarea
                            name="observaciones"
                            id="observaciones"
                            class="form-textarea"
                            maxlength="5000"
                            rows="5"
                            placeholder="Notas adicionales de la consulta..."
                        >{{ old('observaciones') }}</textarea>

                        @error('observaciones')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                </div>

            </div>

        </section>



        {{-- =========================================================
             ACCIONES
        ========================================================== --}}

        <div class="form-actions">

            <a
                href="{{ route('formularios.index') }}"
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
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"></path>
                        <path d="M17 21v-8H7v8"></path>
                        <path d="M7 3v5h8"></path>
                    </svg>
                </span>

                Guardar formulario
            </button>

        </div>

    </form>


    {{-- =========================================================
         AUTOCOMPLETADO
    ========================================================== --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const clienteSelect =
                document.getElementById('id_cliente');

            const citaSelect =
                document.getElementById('id_cita');

            const nombreInput =
                document.getElementById('nombre');

            const contactoInput =
                document.getElementById('contacto');

            const fechaNacimientoInput =
                document.getElementById('fecha_nacimiento');

            const edadInput =
                document.getElementById('edad_visual');

            const pesoInput =
                document.getElementById('peso');

            const estaturaInput =
                document.getElementById('estatura');

            const imcInput =
                document.getElementById('imc_visual');

            const motivoInput =
                document.getElementById('motivo_consulta');


            /*
            |--------------------------------------------------------------------------
            | Calcular edad
            |--------------------------------------------------------------------------
            */

            function calcularEdad() {

                if (
                    !fechaNacimientoInput ||
                    !edadInput
                ) {
                    return;
                }

                const valor =
                    fechaNacimientoInput.value;

                if (!valor) {
                    edadInput.value = '';
                    return;
                }

                const nacimiento =
                    new Date(valor + 'T00:00:00');

                const hoy =
                    new Date();

                let edad =
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
                    edad--;
                }

                edadInput.value =
                    edad >= 0
                        ? edad + ' años'
                        : '';
            }


            /*
            |--------------------------------------------------------------------------
            | Calcular IMC
            |--------------------------------------------------------------------------
            */

            function calcularIMC() {

                if (
                    !pesoInput ||
                    !estaturaInput ||
                    !imcInput
                ) {
                    return;
                }

                const peso =
                    parseFloat(pesoInput.value);

                const estatura =
                    parseFloat(estaturaInput.value);

                if (
                    !peso ||
                    !estatura ||
                    peso <= 0 ||
                    estatura <= 0
                ) {
                    imcInput.value = '';
                    return;
                }

                const imc =
                    peso /
                    (estatura * estatura);

                imcInput.value =
                    imc.toFixed(2);
            }


            /*
            |--------------------------------------------------------------------------
            | Cargar datos del cliente
            |--------------------------------------------------------------------------
            */

            function cargarCliente() {

                if (!clienteSelect) {
                    return;
                }

                const option =
                    clienteSelect.options[
                        clienteSelect.selectedIndex
                    ];

                if (
                    !option ||
                    !option.value
                ) {
                    return;
                }

                const nombre =
                    option.dataset.nombre || '';

                const contacto =
                    option.dataset.contacto || '';

                const fecha =
                    option.dataset.fechaNacimiento || '';

                /*
                 * No reemplazamos old() después
                 * de una validación fallida.
                 */
                if (
                    nombreInput &&
                    !nombreInput.value
                ) {
                    nombreInput.value =
                        nombre;
                }

                if (
                    contactoInput &&
                    !contactoInput.value
                ) {
                    contactoInput.value =
                        contacto;
                }

                if (
                    fechaNacimientoInput &&
                    !fechaNacimientoInput.value
                ) {
                    fechaNacimientoInput.value =
                        fecha;
                }

                calcularEdad();
            }


            /*
            |--------------------------------------------------------------------------
            | Cargar información de cita
            |--------------------------------------------------------------------------
            */

            function cargarCita() {

                if (!citaSelect) {
                    return;
                }

                const option =
                    citaSelect.options[
                        citaSelect.selectedIndex
                    ];

                if (
                    !option ||
                    !option.value
                ) {
                    return;
                }

                const clienteId =
                    option.dataset.cliente;

                const motivo =
                    option.dataset.motivo || '';

                if (
                    clienteId &&
                    clienteSelect
                ) {
                    clienteSelect.value =
                        clienteId;

                    cargarCliente();
                }

                if (
                    motivoInput &&
                    !motivoInput.value
                ) {
                    motivoInput.value =
                        motivo;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Eventos
            |--------------------------------------------------------------------------
            */

            if (clienteSelect) {

                clienteSelect.addEventListener(
                    'change',
                    cargarCliente
                );

            }

            if (citaSelect) {

                citaSelect.addEventListener(
                    'change',
                    cargarCita
                );

            }

            if (fechaNacimientoInput) {

                fechaNacimientoInput.addEventListener(
                    'change',
                    calcularEdad
                );

            }

            if (pesoInput) {

                pesoInput.addEventListener(
                    'input',
                    calcularIMC
                );

            }

            if (estaturaInput) {

                estaturaInput.addEventListener(
                    'input',
                    calcularIMC
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Carga inicial
            |--------------------------------------------------------------------------
            */

            cargarCliente();

            cargarCita();

            calcularEdad();

            calcularIMC();

        });
    </script>

@endsection