<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = Auth::user();

        dd([
    'kelas_user'  => $user ? get_class($user) : 'NULL',
    'id_role'     => $user?->id_role,
    'role_param'  => $role,
]);

        if (!$user) {
            return redirect()->route('login');
        }

        $allowed = match($role) {
            'dinkes'    => (int) $user->id_role === 1,
            'puskesmas' => (int) $user->id_role === 2,
            default     => false,
        };

        if (!$allowed) {
            abort(403, 'Akses tidak diizinkan.');
        }

        return $next($request);
    }
}