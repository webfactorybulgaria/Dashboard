<?php

namespace TypiCMS\Modules\Dashboard\Providers;

use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Shells\Providers\BaseRouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Dashboard\Shells\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        Route::group(['namespace' => $this->namespace], function () {
            /*
             * Admin routes
             */
            Route::get('admin/dashboard', 'AdminController@dashboard')->name('dashboard');
            Route::get('admin', 'AdminController@index');
        });
    }
}
