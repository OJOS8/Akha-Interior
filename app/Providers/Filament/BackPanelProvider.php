<?php

namespace App\Providers\Filament;

use App\Filament\Back\Widgets\AdminSalesOverview;
use App\Filament\Back\Widgets\AdminStatsOverview;
use App\Filament\Back\Widgets\RecentOrders;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class BackPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('back')
            ->path('back')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->brandName('Akha Admin')
            ->discoverResources(
                in: app_path('Filament/Back/Resources'),
                for: 'App\\Filament\\Back\\Resources'
            )
            ->discoverPages(
                in: app_path('Filament/Back/Pages'),
                for: 'App\\Filament\\Back\\Pages'
            )
            ->pages([])
            ->discoverWidgets(
                in: app_path('Filament/Back/Widgets'),
                for: 'App\\Filament\\Back\\Widgets'
            )
            ->widgets([
                AdminStatsOverview::class,
                AdminSalesOverview::class,
                RecentOrders::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
