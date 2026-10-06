<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Formulario;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $hoy = Carbon::today();

        $totalCitas = Cita::count();

        $citasHoy = Cita::query()
            ->whereDate('dia', $hoy)
            ->where('estado', '!=', 'CANCELADA')
            ->count();

        $citasPendientes = Cita::query()
            ->where('estado', 'PENDIENTE')
            ->count();

        $citasConfirmadas = Cita::query()
            ->where('estado', 'CONFIRMADA')
            ->count();

        $totalClientes = Cliente::count();

        $totalFormularios = Formulario::count();

        $proximasCitas = Cita::query()
            ->with('cliente')
            ->whereDate('dia', '>=', $hoy)
            ->where('estado', '!=', 'CANCELADA')
            ->orderBy('dia')
            ->orderBy('hora')
            ->limit(6)
            ->get();

        $citasPorEstado = [
            'pendientes' => Cita::where(
                'estado',
                'PENDIENTE'
            )->count(),

            'confirmadas' => Cita::where(
                'estado',
                'CONFIRMADA'
            )->count(),

            'completadas' => Cita::where(
                'estado',
                'COMPLETADA'
            )->count(),

            'canceladas' => Cita::where(
                'estado',
                'CANCELADA'
            )->count(),
        ];

        return view(
            'dashboard.index',
            compact(
                'totalCitas',
                'citasHoy',
                'citasPendientes',
                'citasConfirmadas',
                'totalClientes',
                'totalFormularios',
                'proximasCitas',
                'citasPorEstado'
            )
        );
    }
}