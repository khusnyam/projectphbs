<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PhbsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/beranda');
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

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar.'])->withInput($request->only('email'));
        }

        if ($user->status_aktif == 0) {
            return back()->withErrors(['email' => 'Akun Anda tidak aktif. Hubungi Admin.'])->withInput($request->only('email'));
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'id_role'=>1], $request->has('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/beranda');
        }elseif (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'id_role'=>2], $request->has('remember'))) {
            $request->session()->regenerate();    
            return redirect()->intended('/dashboard-puskesmas');
        }

        return back()->withErrors(['password' => 'Password yang Anda masukkan salah.'])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}