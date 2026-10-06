<?php

namespace App\Http\Controllers;

use App\Models\Nutriologo;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function inicio(): View
    {
        $nutriologo = Nutriologo::query()
            ->where('activo', true)
            ->first();

        return view(
            'public.inicio',
            compact('nutriologo')
        );
    }

    public function citas(): View
    {
        return view('public.citas');
    }
}