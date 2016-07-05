<?php

namespace App\Http\Controllers\NotAuth;

use App\Models\Work\Team\TeamOrder;
use Illuminate\Foundation\Bus\DispatchesJobs;

class IndexController extends GuestController
{
    use DispatchesJobs;


    public function index()
    {
        if (\Auth::id()) {
            return \Redirect::route('profile_page');
        }

//// Create a post hash
//        $key = 'post:'.$post->getId();
//        $this->redis->hSet($key, 'data', serialize($post->toArray()));

//        $expiredLots = AuctionLot::where(DB::raw('TIMESTAMPDIFF(SECOND, now(), auction_lot.date_time)'), '>', 0)
//            ->select('id', 'thing_id')->get();

        $expiredLots_ids = '';


//        Queue::push('MyQueue', array());
//        $this->dispatch(new SendMessageToWorker());

//        $job = (new SendMessageToWorker())->onQueue('emails');
//
//        $this->dispatch($job);
//
//
//        $job = (new SendMessageToWorker())->delay(60 * 5);
//
//        $this->dispatch($job);



        return view('index', [
        ]);
    }

    public function test ()
    {

        $a = null;

        $b = $a == null ? $c = 4 : 5;

/*
        $order_id = 9;

        $order = OrderRepository::findOrderById($order_id);
        $orderSM = new OrderStateMachine($order);
        $sm = $orderSM->getSM();

        // Retrieve current state
        $aa = $sm->getCurrentState();

// Can we process a transition ?
        $aa = $sm->can('finish_stock_materials');
        $aa = $sm->apply('finish_stock_materials');*/


//        GeoFactory::createTravelShipWithMaterials(5, $auctionStartStr);

/*        $this->dispatch(new SendMessageToWorker());
        Queue::pushOn('emails', new SendMessageToWorker());

        $job = (new SendMessageToWorker())->onQueue('post_messages');

        $this->dispatch($job);


        $date = Carbon::now()->addSeconds(25);

        Queue::later($date, new SendMessageToWorker());*/

//        $allUSers = User::get();
//
//        $allUSers->each(function ($user, $key) {
////          $user->status = 'free';
////            $user->save();
////            UserRedis::loginUser($user);
//
//        });

        /** @var TeamOrder $order */
//         $order = TeamOrder::select('id', 'price')
//            ->with('materials')
//            ->findOrFail(5);
//
//        $mat = $order->deleteMaterialByCode('ste7klo');
//        $mat = $order->materialByCode('steklo');
//        $mats = $order->materials();
//        $m = $mats->where('code', 'pesok');//->first();

        return view('index', [
            // 'lot' => $lot,
        ]);
    }
}
