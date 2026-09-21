<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        // Hanya data milik user login. Jangan tampilkan data user lain.
        return view('pages.account-index', ['user' => $request->user()]);
    }

    public function profile(Request $request)
    {
        return view('pages.account-profile', ['user' => $request->user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email,'.$user->id],
        ]);

        // Role tidak bisa diubah dari sini. Abaikan field role bila dikirim client.
        $user->fill($validated)->save();

        return redirect('/account/profile')->with('status', 'Profil tersimpan.');
    }
}
