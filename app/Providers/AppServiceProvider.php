<?php

namespace App\Providers;

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
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('global_settings')) {
                $globalSettings = \App\Models\GlobalSetting::pluck('value', 'key')->toArray();
                view()->share('globalSettings', $globalSettings);
            }

            // Share projects with navigation for the Query Modal
            view()->composer('layouts.navigation', function ($view) {
                if (auth()->check() && auth()->user()->company) {
                    $view->with('navProjects', auth()->user()->company->projects()->orderBy('name')->get());
                }
            });
        } catch (\Exception $e) {
            // Table doesn't exist yet
        }
    }
}
