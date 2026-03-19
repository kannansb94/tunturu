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
        if (config('app.url')) {
            \Illuminate\Support\Facades\URL::forceRootUrl(config('app.url'));
        }

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $appName = \App\Models\Setting::where('key', 'app_name')->value('value');
                if ($appName) {
                    config(['mail.from.name' => $appName]);
                    config(['app.name' => $appName]);
                }
            }
        } catch (\Exception $e) {
            // Do nothing if DB isn't ready
        }

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            try {
                $settings = \App\Models\Setting::whereIn('key', ['app_logo', 'app_name'])->pluck('value', 'key');
                $view->with('app_logo', $settings['app_logo'] ?? null);
                $view->with('app_name', $settings['app_name'] ?? config('app.name'));
            } catch (\Exception $e) {
                $view->with('app_logo', null);
                $view->with('app_name', config('app.name'));
            }
        });

        // Define Gates for Permissions
        $permissions = [
            'manage_users',
            'manage_books',
            'manage_settings',
            'view_reports',
            'manage_rentals',
            'manage_sales',
            'manage_categories',
            'manage_donations', // Added for consistency, even if not in DB yet, hasPermission handles SuperAdmin bypass
        ];

        foreach ($permissions as $permission) {
            \Illuminate\Support\Facades\Gate::define($permission, function ($user) use ($permission) {
                return $user->hasPermission($permission);
            });
        }
    }
}
