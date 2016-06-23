<?php

namespace App\Http\Middleware\Work;

use App\Repositories\Work\Team\TeamOrderRepository;
use App\Repositories\Work\Team\TeamWorkerRepository;
use Closure;
use Illuminate\Support\Facades\Session;
use Redirect;

class TeamOrderAcceptor
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
        if ($order_id = $request->get('order_id')) {

            $order = TeamOrderRepository::getOrderById($order_id);
            $worker = TeamWorkerRepository::findById(\Auth::id());
            $team = $worker->team;

            if ($worker->team->id == $order->acceptor_team_id) {
                Session::flash('message', 'It\'s order of your private-team');
                return Redirect::route('work_show_teamorder_page', ['id' => $order->id]);
            }
            elseif ($worker->id != $team->leader_worker_id) {
                Session::flash('message', 'Accept order can ONLY team-leader!');
                return Redirect::route('work_teamorders_page');
            }
            elseif ($order->acceptor_team_id != null) {
                Session::flash('message', 'Order is accepted yet!');
                return Redirect::route('work_teamorders_page');
            }
            else { // order is free

                return $next($request);
            }
        }

        Session::flash('message', 'Unknown order');
        return Redirect::route('work_teamorders_page');
    }
}
