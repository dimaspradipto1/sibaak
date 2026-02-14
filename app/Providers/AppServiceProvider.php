<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;

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
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        Paginator::useBootstrap();

        // View composer for navbar and sidebar notifications
        view()->composer(['layouts.dashboard.navbar', 'layouts.dashboard.sidebar'], function ($view) {
            $pendingSuratAktif = \App\Models\SuratAktif::where('status', 'pending')->count();

            $recentArsip = \App\Models\RekapitulasiArsip::with([
                'skKepanitiaan',
                'lpjKepanitiaan',
                'kurikulum',
                'pedoman',
                'sopAkademik',
                'wasdalbin'
            ])->latest()->take(5)->get();

            $totalPending = $pendingSuratAktif;

            $view->with([
                'pendingSuratAktifCount' => $pendingSuratAktif,
                'pendingSuratAkademikCount' => 0,
                'totalPending' => $totalPending,
                'recentArsip' => $recentArsip
            ]);
        });
    }
}
