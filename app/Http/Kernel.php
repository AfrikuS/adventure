<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
        ],

        'api' => [
            'throttle:60,1',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'app_auth' => \App\Http\Middleware\AppAuth::class,
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'can' => \Illuminate\Foundation\Http\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        'work_order_acceptor' => \App\Http\Middleware\Work\OrderAcceptor::class,
        'work_teamorder_partner' => \App\Http\Middleware\Work\TeamOrderPartner::class,
        'work_worker_one_leader' => \App\Http\Middleware\Work\WorkerLeaderOnlyOneTeam::class,
        'work_worker_belong_team' => \App\Http\Middleware\Work\WorkerBelongTeam::class,
        'work_leader_team' => \App\Http\Middleware\Work\WorkerLeaderTeam::class,
        'work_teamorder_acceptor' => \App\Http\Middleware\Work\TeamOrderAcceptor::class,
        
        
        'drive_driver' => \App\Http\Middleware\DriverMiddleware::class,
        'drive_vehicle_broken' => \App\Http\Middleware\VehicleBrokenMiddleware::class,
    ];
}
