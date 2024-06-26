<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('Worker', function () {
            return Auth::check() && in_array(Auth::user()->role, ['Admin', 'Worker']);
        });

        Blade::if('Admin', function () {
            return Auth::check() && in_array(Auth::user()->role, ['Admin']);
        });

    }
}
