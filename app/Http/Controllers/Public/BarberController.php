<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Barber;

class BarberController extends Controller
{
    public function index()
    {
        return view('pages.barbers-index', [
            'barbers' => Barber::active()->orderBy('name')->get(),
        ]);
    }

    public function show(string $slug)
    {
        $barber = Barber::active()
            ->with('services')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('pages.barbers-show', ['barber' => $barber]);
    }
}
