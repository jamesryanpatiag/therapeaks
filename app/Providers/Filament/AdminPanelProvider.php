<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;
use Filament\Navigation\MenuItem;
use Filament\Support\Enums\MaxWidth;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use App\Filament\Pages\Profile;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('Your Custom Brand Name')
            ->colors([
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'primary' => "#0d9f99",
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
            ])
            ->maxContentWidth(MaxWidth::Full)
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
            ->plugins([
                FilamentShieldPlugin::make(),
                \Ercogx\FilamentOpenaiAssistant\OpenaiAssistantPlugin::make()
                ->setRegistrablePages([
                    \App\Filament\Pages\ChatPage::class
                ]),
                FilamentFullCalendarPlugin::make()
                        ->selectable()
                        ->editable(),
                FilamentEditProfilePlugin::make()
                    ->slug('my-profile')
                    ->shouldShowAvatarForm()
                    ->setNavigationLabel('My Profile')
                    ->setNavigationGroup('Group Profile')
                    ->setIcon('heroicon-o-user')
                    ->setTitle('My Profile')
                    ->shouldShowBrowserSessionsForm(false)     
                    ->shouldShowEmailForm()      
            ])
            ->brandLogo(asset('images/therapeaks.png'))
            ->brandLogoHeight('3.5rem')
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
