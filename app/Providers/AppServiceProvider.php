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
        // Debug: Lacak semua gate check yang terjadi
        Gate::after(function ($user, $ability, $result, $arguments) {
            Log::info('GATE CHECK', [
                'ability' => $ability,
                'result'  => $result,
                'user_id' => $user?->id,
                'trace'   => collect(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 8))
                                ->pluck('function')->join(' → '),
            ]);
        });

        Gate::define('akses-dinkes', function ($user) {
            return $user->id_role == 1;
        });

        Gate::define('akses-puskesmas', function ($user) {
            return $user->id_role == 2;
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