<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return view('pages.services-index', [
            'services' => Service::active()->with('barbers')->orderBy('price')->get(),
        ]);
    }

    public function show(string $slug)
    {
        $service = Service::active()
            ->with('barbers')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('pages.services-show', ['service' => $service]);
    }
}
