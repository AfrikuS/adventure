<?php

namespace App\Console\Commands;

use App\Repositories\HeroRepositoryObj;
use Illuminate\Console\Command;

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

    /** @var  AuctionRepository */
    protected $auctionRepo;
    /** @var  HeroRepositoryObj */
    private $heroRepo;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AuctionRepository $auctionRepo, HeroRepositoryObj $heroRepo)
    {
        $this->auctionRepo = $auctionRepo;
        $this->heroRepo = $heroRepo;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $expiredLots = $this->auctionRepo->getExpiredLots();

        $purchaseCommand = new CommitPurchasingCommand($this->auctionRepo, $this->heroRepo);
        
        $removeCommand = new RemoveLotFromAuction($this->auctionRepo, $this->heroRepo);

        foreach ($expiredLots as $lot) {
            
            if (isset($lot->purchaser_id)) {

                $purchaseCommand->commitPurchasing($lot->id, $lot->purchaser_id);
            }
            else {
                $removeCommand->removeLotFromAuction($lot);
            }
        }
    }
}
