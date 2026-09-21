<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;

class PasswordResetController extends Controller
{
    public function showForgot()
    {
        return view('pages.auth-forgot');
    }

    public function sendLink(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Link reset dikirim ke email bila alamat terdaftar. Cek inbox dan folder spam.')
            : back()->withErrors(['email' => 'Link tidak bisa dikirim. Coba lagi beberapa saat.']);
    }

    public function showReset(string $token)
    {
        return view('pages.auth-reset', [
            'token' => $token,
            'email' => request()->query('email', ''),
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            fn ($user, $password) => $user->forceFill(['password' => $password])->save()
        );

        return $status === Password::PASSWORD_RESET
            ? redirect('/login')->with('status', 'Password baru tersimpan. Masuk dengan password baru.')
            : back()->withErrors(['email' => 'Token tidak valid atau kedaluwarsa. Minta link baru di halaman lupa password.']);
    }
}
