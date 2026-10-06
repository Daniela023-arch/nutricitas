<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClienteController extends Controller
{
    public function index(Request $request): View
    {
        $query = Cliente::query()
            ->withCount([
                'citas',
                'formularios',
            ]);

        if ($request->filled('buscar')) {
            $buscar = trim(
                $request->input('buscar')
            );

            $query->where(function ($q) use ($buscar) {
                $q->where(
                    'nombre',
                    'like',
                    "%{$buscar}%"
                )
                ->orWhere(
                    'apellido',
                    'like',
                    "%{$buscar}%"
                )
                ->orWhere(
                    'correo',
                    'like',
                    "%{$buscar}%"
                )
                ->orWhere(
                    'telefono',
                    'like',
                    "%{$buscar}%"
                );
            });
        }

        $clientes = $query
            ->orderBy('nombre')
            ->orderBy('apellido')
            ->paginate(10)
            ->withQueryString();

        return view(
            'clientes.index',
            compact('clientes')
        );
    }
}