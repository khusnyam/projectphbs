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
        
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
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

        // Cek password
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember'))) {
            return back()
                ->withErrors(['password' => 'Password yang Anda masukkan salah.'])
                ->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        // Redirect berdasarkan role
        $role = Auth::user()->role->role ?? 'puskesmas';

        if ($role === 'dinkes') {
            return redirect()->route('dashboard.dinkes');
        }

        return redirect()->route('dashboard.puskesmas');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}