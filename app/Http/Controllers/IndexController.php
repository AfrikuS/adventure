<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Guest\GuestController;
use App\Jobs\SendMessageToWorker;
use App\Models\HeroThing;
use App\Models\Macro\Resources;
use App\Models\User;
use App\Models\UserRedis;
use App\Models\Work\Team\TeamOrder;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Redis;
use Mail;
use stdClass;

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

        $job = (new SendMessageToWorker())->onQueue('emails');

        $this->dispatch($job);


        $job = (new SendMessageToWorker())->delay(60 * 5);

        $this->dispatch($job);



        return view('index', [
        ]);
    }

    public function test ()
    {

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
