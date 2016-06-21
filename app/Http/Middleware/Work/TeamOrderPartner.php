<?php

namespace App\Http\Middleware\Work;

use App\Repositories\Work\Team\TeamOrderRepository;
use Closure;
use Illuminate\Support\Facades\Session;

class TeamOrderPartner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (($order_id = $request->route()->parameter('id')) || ($order_id = $request->get('order_id'))) {

            $order = TeamOrderRepository::getOrderById($order_id);
            $user = \Auth::user();
            
            if ($order && TeamOrderRepository::belongUserToTeamOrder($user, $order)) {
                return $next($request);
            }
        }

        Session::flash('message', 'This order not your private-team!');
        return redirect()->back();
    }
}
