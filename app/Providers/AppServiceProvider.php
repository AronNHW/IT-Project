<?php

namespace App\Providers;

use App\Models\Divisi;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('semua_divisi', Divisi::all());
            $view->with('logo', Setting::where('key', 'logo')->first());
        });
    }
}
