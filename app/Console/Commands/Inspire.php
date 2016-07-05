<?php

namespace App\Console\Commands;

use App\Models\AuctionLot;
use App\Models\Sea\TravelOrder;
use App\Models\Sea\TravelShip;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\DB;

class Inspire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inspire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $expiredOrders = DB::table('sea_travel_orders')
            ->select('sea_travel_orders.id AS id')
            ->addSelect('sea_travel_orders.user_id AS user_id')
            ->addSelect(DB::raw('TIMESTAMPDIFF(SECOND, now(), sea_travel_orders.date_time) AS duration_seconds'))
            ->havingRaw('duration_seconds < 0')
            ->get();

        DB::beginTransaction();
        foreach ($expiredOrders as $order) {
            $user = User::find($order->user_id);//where('order_id', '=', $order->id)->first();
            $resources = $user->resources;
            $resources->oil += 7;
            $resources->water += 8;
            $resources->gold += 5;
            $resources->save();

            TravelOrder::destroy($order->id);
        }
        DB::commit();

    }
}
