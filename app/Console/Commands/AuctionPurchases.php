<?php

namespace App\Console\Commands;

use App\Domain\AuctionActions;
use App\Models\AuctionLot;
use App\Models\HeroResources;
use App\Models\HeroThing;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AuctionPurchases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:purchases';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commit expired auction lots';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $expiredLots = AuctionLot::where(DB::raw('TIMESTAMPDIFF(SECOND, now(), auction_lot.date_time)'), '<', 0)
//            ->get();
        $expiredLots = AuctionLot::where(DB::raw('TIMESTAMPDIFF(SECOND, now(), auction_lot.date_time)'), '<', 0)
            ->select('id', 'thing_id')->get();


        foreach ($expiredLots as $lot) {
            if (isset($lot->purchaser_id)) {

                DB::beginTransaction();
                
                AuctionActions::commitPurchase($lot);

                DB::commit();
            }
            else {
                AuctionActions::rollbackLot($lot);
            }
        }


    }
}
