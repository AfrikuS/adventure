<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        $router->group(['namespace' => $this->namespace, 'middleware' => 'web'], function ($router) {
            require app_path('Http/Controllers/NotAuth/routes.php');

            $router->group(['middleware' => 'app_auth'], function () {

//                require app_path('Http/Controllers/Profile/_routes.php');
//                require app_path('Http/Controllers/Drive/_routes.php');
//                require app_path('Http/Controllers/Geo/_routes.php');
                require app_path('Http/Controllers/Work/_routes.php');
                require app_path('Http/Controllers/Railway/_routes.php');

//                require app_path('Http/Controllers/Employment/_routes.php');


            });

            require app_path('Http/routes.php');
        });

        $router->group(['namespace' => 'App\Modules', 'middleware' => 'web'], function ($router) {

            $router->group(['middleware' => 'app_auth'], function () {

                require app_path('Modules/Drive/Resources/routes.php');
                require app_path('Modules/Work/Resources/routes.php');
                require app_path('Modules/Employment/Resources/_routes.php');

                require app_path('Modules/Profile/Resources/routes.php');
                require app_path('Modules/Hero/Resources/routes.php');
                require app_path('Modules/Npc/Resources/routes.php');
                require app_path('Modules/Battle/Resources/routes.php');
                
                
                require app_path('Modules/Auction/Http/routes.php');

                require app_path('Modules/Geo/Resources/Routes/_routes.php');
                require app_path('Modules/Geo/Resources/Routes/business.php');
                require app_path('Modules/Geo/Resources/Routes/admin.php');
                require app_path('Modules/Oil/Resources/routes.php');
            });
        });
    }
}
