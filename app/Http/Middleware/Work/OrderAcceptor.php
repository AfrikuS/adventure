<?php

namespace App\Http\Middleware\Work;

use App\Models\Work\Order;
use App\Repositories\Work\OrderRepository;
use App\Repositories\Work\Team\WorkerRepository;
use Closure;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class OrderAcceptor
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

            $worker = WorkerRepository::findWithMaterialsAndSkillsById(\Auth::id());
            /** @var Order $order */
            $order = OrderRepository::findOrderWithMateriaslAndSkillsById($order_id);

            if ($order->isAcceptedBy($worker)) {
                $request->attributes->add([
                    'worker' => $worker,
                    'order' => $order,
                ]);

                return $next($request);
            }

        }

        Session::flash('message', 'This order not yours!');
        return redirect()->back(); // todo danger - > change on concrete path
    }
}
