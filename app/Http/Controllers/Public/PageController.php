<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Media;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function gallery()
    {
        return view('pages.gallery', [
            'items' => Media::where('collection', 'gallery')->orderBy('id')->get(),
        ]);
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactStore(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        ContactMessage::create($validated);

        return redirect('/contact')->with('status', 'Pesan tersimpan. Kami membalas melalui email setelah membaca pesan.');
    }
}
