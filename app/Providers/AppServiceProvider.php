<?php

namespace App\Providers;

use App\View\Composers\FrontComposer;
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
        View::composer([
            'front.layouts.app',
            'front.partials.navbar',
            'front.partials.footer',
        ], FrontComposer::class);
    }
}
