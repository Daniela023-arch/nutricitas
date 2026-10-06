<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Sitio público
|--------------------------------------------------------------------------
*/

Route::get(
    '/',
    [PublicController::class, 'inicio']
)->name('inicio');

Route::get(
    '/agendar-cita',
    [PublicController::class, 'citas']
)->name('citas.publicas');

Route::post(
    '/agendar-cita',
    [CitaController::class, 'storePublic']
)->name('citas.publicas.guardar');

Route::get(
    '/disponibilidad',
    [CitaController::class, 'disponibilidad']
)->name('citas.disponibilidad');

/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
*/

Route::get(
    '/login',
    [AuthController::class, 'showLogin']
)->name('login');

Route::post(
    '/login',
    [AuthController::class, 'login']
)->name('login.procesar');

Route::post(
    '/logout',
    [AuthController::class, 'logout']
)->name('logout');

/*
|--------------------------------------------------------------------------
| Área privada
|--------------------------------------------------------------------------
*/

Route::middleware('nutriologo.auth')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [DashboardController::class, 'index']
        )->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Citas
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/citas',
            [CitaController::class, 'index']
        )->name('citas.index');

        Route::get(
            '/calendario',
            [CitaController::class, 'calendario']
        )->name('citas.calendario');

        Route::get(
            '/calendario/eventos',
            [CitaController::class, 'eventosCalendario']
        )->name('citas.calendario.eventos');

        Route::patch(
            '/citas/{cita}/estado',
            [CitaController::class, 'updateEstado']
        )->name('citas.estado');

        /*
        |--------------------------------------------------------------------------
        | Clientes
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/clientes',
            [ClienteController::class, 'index']
        )->name('clientes.index');

        /*
        |--------------------------------------------------------------------------
        | Formularios clínicos
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/formularios',
            [FormularioController::class, 'index']
        )->name('formularios.index');

        Route::get(
            '/formularios/nuevo',
            [FormularioController::class, 'create']
        )->name('formularios.create');

        Route::post(
            '/formularios',
            [FormularioController::class, 'store']
        )->name('formularios.store');

        Route::get(
            '/formularios/{formulario}',
            [FormularioController::class, 'show']
        )->name('formularios.show');

        Route::get(
            '/formularios/{formulario}/editar',
            [FormularioController::class, 'edit']
        )->name('formularios.edit');

        Route::put(
            '/formularios/{formulario}',
            [FormularioController::class, 'update']
        )->name('formularios.update');

        Route::delete(
            '/formularios/{formulario}',
            [FormularioController::class, 'destroy']
        )->name('formularios.destroy');
    });