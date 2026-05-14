<?php

namespace App\Providers;

use App\Models\Service;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('settings', function () {
            try {
                return Setting::getInstance();
            } catch (\Exception $e) {
                return new Setting();
            }
        });
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('settings', app('settings'));
        });

        $navServicesCallback = function ($view) {
            try {
                $navServices = Service::where('is_active', true)
                    ->orderBy('sort_order')
                    ->get(['id', 'title', 'slug', 'icon']);
            } catch (\Exception $e) {
                $navServices = collect();
            }
            $view->with('navServices', $navServices);
        };

        View::composer('layouts.partials.navbar', $navServicesCallback);
        View::composer('layouts.partials.footer', $navServicesCallback);
    }
}
