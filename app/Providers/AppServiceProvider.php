<?php

namespace App\Providers;

use App\Models\Pengaturan;
use App\View\Components\PublikLayout;
use Illuminate\Support\Facades\Blade;
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
        // Alias layout publik (mirip x-app-layout bawaan Breeze)
        Blade::component('publik-layout', PublikLayout::class);

        // Hero global (gambar/video dari admin) tersedia di semua view tanpa tiap controller.
        view()->composer(['welcome', 'dashboard'], function ($view) {
            $view->with('heroMedia', Pengaturan::current());
        });
    }
}
