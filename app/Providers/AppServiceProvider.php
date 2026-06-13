<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // <--- 1. Tambahkan ini di paling atas!
use Illuminate\Support\Facades\Log;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Biarkan kosong
    }

    

    public function boot(): void
    {
        // DEBUG: Log gate checks
        Gate::after(function ($user, $ability, $result, $arguments) {
            Log::info('GATE_CHECK', [
                'ability'   => $ability,
                'result'    => $result,
                'user_id'   => $user?->id_user,
                'user_role' => $user?->id_role,
                'user_email' => $user?->email,
            ]);
        });

        // Gate untuk Dinkes (role 1)
        Gate::define('akses-dinkes', function ($user) {
            $allowed = $user && $user->id_role == 1;
            Log::info('GATE_DINKES', [
                'user_id' => $user?->id_user,
                'user_role' => $user?->id_role,
                'allowed' => $allowed,
            ]);
            return $allowed;
        });

        // Gate untuk Puskesmas (role 2)
        Gate::define('akses-puskesmas', function ($user) {
            $allowed = $user && $user->id_role == 2;
            Log::info('GATE_PUSKESMAS', [
                'user_id' => $user?->id_user,
                'user_role' => $user?->id_role,
                'allowed' => $allowed,
            ]);
            return $allowed;
        });
    }

    /**
     * Bootstrap any application services.
     */
    // public function boot(): void
    // {
    //     Gate::define('akses-dinkes', function ($user) {
    //         return $user->id_role == 1; 
    //     });

    //     Gate::define('akses-puskesmas', function ($user) {
    //         return $user->id_role == 2; 
    //     });
    // }
}