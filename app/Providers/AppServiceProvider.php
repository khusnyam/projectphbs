<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // <--- 1. Tambahkan ini di paling atas!
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;


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
    // Gate::define('akses-dinkes', function ($user) {
    //     // return session('user_role') === 1 || $user->isDinkes();
    //     return $user->id_role == 1;
    // });

    // Gate::define('akses-puskesmas', function ($user) {
    //     // return session('user_role') === 2 || $user->isPuskesmas();
    //     return $user->id_role == 2;
    // });
    Gate::define('akses-puskesmas', function ($user) {
    dd([
        'GATE DIPANGGIL' => true,
        'id_role'        => $user->id_role,
        'hasil'          => $user->id_role == 2,
    ]);
    return $user->id_role == 2;
});
}
};







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
