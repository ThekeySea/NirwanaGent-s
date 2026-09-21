<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/design', function () {
    abort_if(app()->isProduction(), 404);

    return view('pages.design');
});
