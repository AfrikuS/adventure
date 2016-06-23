<?php

namespace App\Console\Commands;

use App\Domain\AuctionActions;
use App\Models\Trade\AuctionLot;
use App\Models\User;
use App\Repositories\AuctionRepository;
use App\Transactions\Trade\AuctionTransactions;
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
        $expiredLots = AuctionRepository::getExpiredLots();

        foreach ($expiredLots as $lot) {
            if (isset($lot->purchaser_id)) {

                $purchaser = User::find($lot->purchaser_id);

                AuctionTransactions::commitPurchasing($lot, $purchaser);
            }
            else {
                $lot->delete(); // todo review thing-status = free?
            }
        }
    }
}
