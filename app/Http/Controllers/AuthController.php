<?php

namespace App\Http\Controllers;

use App\Models\Nutriologo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Mostrar login
    |--------------------------------------------------------------------------
    */

    public function showLogin(Request $request): View|RedirectResponse
    {
        if ($request->session()->has('nutriologo_id')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | Procesar inicio de sesión
    |--------------------------------------------------------------------------
    */

    public function login(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'correo' => [
                'required',
                'email',
                'max:150',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);

        $nutriologo = Nutriologo::query()
            ->where('correo', $datos['correo'])
            ->where('activo', true)
            ->first();

        if (
            !$nutriologo ||
            !Hash::check(
                $datos['password'],
                $nutriologo->password
            )
        ) {
            return back()
                ->withInput(
                    $request->only('correo')
                )
                ->withErrors([
                    'correo' => 'El correo o la contraseña son incorrectos.',
                ]);
        }

        /*
         * Únicamente permitimos el acceso
         * al superadministrador.
         */
        if ($nutriologo->rol !== 'SUPERADMINISTRADOR') {
            return back()
                ->withInput(
                    $request->only('correo')
                )
                ->withErrors([
                    'correo' => 'No tienes autorización para acceder al sistema.',
                ]);
        }

        /*
         * Regeneramos la sesión para evitar
         * session fixation.
         */
        $request->session()->regenerate();

        $request->session()->put([
            'nutriologo_id' =>
                $nutriologo->id_nutriologo,

            'nutriologo_nombre' =>
                $nutriologo->nombre,

            'nutriologo_apellido' =>
                $nutriologo->apellido,

            'nutriologo_correo' =>
                $nutriologo->correo,

            'nutriologo_rol' =>
                $nutriologo->rol,
        ]);

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Bienvenido al panel administrativo.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Cerrar sesión
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with(
                'success',
                'La sesión se cerró correctamente.'
            );
    }
}