<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Register;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\MenuItem;
use Filament\FontProviders\GoogleFontProvider;
use App\Filament\Pages\Auth\RegisterStore;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Auth;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->registration(RegisterStore::class)
            // ->profile(\App\Filament\Pages\Auth\EditStoreProfile::class)
            ->passwordReset()
            ->maxContentWidth('full')
            ->brandLogo(asset('assets/images/logopm2.svg'))
            ->brandLogoHeight('3rem')
            ->renderHook(
                PanelsRenderHook::CONTENT_START,
                fn(): string => view('filament.hooks.profile-warning')->render(),
            )
            // ->emailVerification()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->favicon(asset('assets/images/logo.svg'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \Filament\Pages\Dashboard::class, // <-- PERBAIKANNYA DI SINI
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Tambahkan widget yang kita buat tadi agar muncul di halaman depan dashboard
                \App\Filament\Widgets\StatsInfoPenting::class,
            ])
            ->font('Plus Jakarta Sans', provider: GoogleFontProvider::class)
            ->sidebarCollapsibleOnDesktop()
            ->userMenuItems([
                // 1. TOMBOL MENUJU TOKO MASING-MASING
                MenuItem::make()
                    ->label('Lihat Toko Saya')
                    ->icon('heroicon-o-building-storefront')
                    ->url(fn (): string => Auth::user()?->username ? route('index', Auth::user()->username) : '/')
                    // Tombol ini HANYA TAMPIL jika yang login adalah pemilik toko
                    ->visible(fn (): bool => Auth::user()?->role === 'store'),

                // 2. TOMBOL MENUJU LANDING PAGE (Opsional, untuk Admin saja)
                MenuItem::make()
                    ->label('Pergi ke Landing Page')
                    ->url('/')
                    ->icon('heroicon-o-globe-alt'),
                    // Tombol ini HANYA TAMPIL untuk Admin pusat
                    // ->visible(fn (): bool => Auth::user()?->role === 'admin')
            ])
            // ---------------------------
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->darkMode(false)
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
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
