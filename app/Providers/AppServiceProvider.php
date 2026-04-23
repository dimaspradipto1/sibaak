<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;
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

        // Register Dynamic Gates from Database
        try {
            if (Schema::hasTable('permissions')) {
                $permissions = \App\Models\Permission::all();
                foreach ($permissions as $permission) {
                    Gate::define($permission->slug, function ($user) use ($permission) {
                        return $user->role && $user->role->hasPermission($permission->slug);
                    });
                }
            }
        } catch (\Exception $e) {
            // Silently fail if table doesn't exist yet
        }

        // Grant all permissions to SUPER ADMIN and ADMIN
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('SUPER ADMIN') || $user->hasRole('ADMIN')) {
                return true;
            }
        });

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
