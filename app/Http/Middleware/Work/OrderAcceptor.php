<?php

namespace App\Http\Middleware\Work;

use App\Repositories\Work\OrderRepository;
use App\Repositories\Work\OrderRepositoryObj;
use Closure;
use Illuminate\Support\Facades\Session;
use App\Validators\Work\OrderAcceptorValidator;

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

            $validator = new OrderAcceptorValidator(new OrderRepositoryObj());

            if ($validator->isOrderAcceptor(\Auth::id(), $order_id)) {
                return $next($request);
            }
        }

        Session::flash('message', 'It\'s not your order!');
        return redirect()->back(); // todo danger - > change on concrete path
    }
}
