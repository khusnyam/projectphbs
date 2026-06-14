<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('akses-dinkes', function ($user) {
            return $user->id_role == 1;
        });

        Gate::define('akses-puskesmas', function ($user) {
            return $user->id_role == 2;
        });
    }
}