<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\Media;
use App\Models\Product;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home', [
            'featuredServices' => Service::active()->orderBy('price')->take(2)->get(),
            'featuredBarbers' => Barber::active()->orderBy('name')->take(3)->get(),
            'featuredProducts' => Product::active()->orderBy('name')->take(3)->get(),
            'gallery' => Media::where('collection', 'gallery')->take(3)->get(),
        ]);
    }
}
