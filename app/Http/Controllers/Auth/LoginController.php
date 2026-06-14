<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        // Cek apakah email terdaftar
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'Email tidak terdaftar.'])
                ->withInput($request->only('email'));
        }

        // Cek status aktif
        if (!$user->status_aktif) {
            return back()
                ->withErrors(['email' => 'Akun Anda tidak aktif. Hubungi Admin.'])
                ->withInput($request->only('email'));
        }

        // Attempt login
        if (!Auth::attempt(
            ['email' => $request->email, 'password' => $request->password],
            $request->boolean('remember')
        )) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        // Simpan role ke session
        // $user = Auth::user();
        session([
            'user_role'      => (int) $user->id_role,
            'user_name'      => $user->name,
        ]);

        // Redirect berdasarkan role
        return $user->isDinkes()
            ? redirect()->route('beranda')
            : redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}