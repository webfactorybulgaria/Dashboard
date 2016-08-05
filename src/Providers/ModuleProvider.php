<?php

namespace TypiCMS\Modules\Dashboard\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Custom\Services\Cache\LaravelCache;
use TypiCMS\Modules\Dashboard\Custom\Repositories\CacheDecorator;
use TypiCMS\Modules\Dashboard\Custom\Repositories\EloquentDashboard;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.dashboard'
        );

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'dashboard');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'dashboard');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/dashboard'),
        ], 'views');
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Dashboard\Custom\Providers\RouteServiceProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Dashboard\Custom\Composers\SidebarViewComposer');

        $app->bind('TypiCMS\Modules\Dashboard\Custom\Repositories\DashboardInterface', function (Application $app) {
            $repository = new EloquentDashboard();
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'dashboard', 10);

            return new CacheDecorator($repository, $laravelCache);
        });
    }
}
