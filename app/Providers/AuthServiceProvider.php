<?php

namespace App\Providers;

use App\Models\Auth\UserRedis;
use App\Models\Work\Team\TeamOrder;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        Auth::provider('user_redis_provider', function($app, array $config) {
            return new RedisUserProvider(UserRedis::class);
        });
        //

        $gate->define('view-teamorder', 'App\Policies\ViewTeamOrderPolicy@check');
        $gate->define('teamorder-accepted', 'App\Policies\TeamOrderAcceptedPolicy@check');
    }
}
