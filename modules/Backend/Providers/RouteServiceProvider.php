<?php

namespace Modules\Backend\Providers;

use Illuminate\Routing\Router;
use Illuminate\Http\Request;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = null;

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);
        //
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
//	public function map(Router $router, Request $request)
//	{
//		$locale = $request->segment(1);
//		$this->app->setLocale($locale);
//		$router->group(['namespace' => $this->namespace, 'prefix' => $locale], function($router) {
//			require app_path('Http/routes.php');
//		});
//	}

    public function map(Router $router, Request $request)
    {
//		$locale = $request->segment(1);
//
//                $locales = config('app.locales');
//
//                if (array_key_exists($locale, $locales)) {
//                    $this->app->setLocale($locale);
//                } else {
//                    $locale = array_keys($locales)[0];
//                    $this->app->setLocale($locale);
//                }

        $router->group(['prefix' => 'backend'], function($router) {
            require base_path('modules/Backend/Http/routes.php');
        });
    }

}
