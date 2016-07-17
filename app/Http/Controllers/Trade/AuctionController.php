<?php

namespace App\Http\Controllers\Trade;

use App\Commands\Trade\Auction\CommitPurchasingCommand;
use App\Commands\Trade\Auction\CommitPurchasingContext;
use App\Commands\Trade\Auction\CreateLotCommand;
use App\Commands\Trade\Auction\CreateLotContext;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\AuctionAddLotRequest;
use App\Http\Requests\AuctionBuyLotRequest;
use App\Repositories\HeroRepository;
use App\Repositories\HeroRepositoryObj;
use App\Repositories\Trade\AuctionRepository;
use App\Serializers\RedisAuctionLot;
use App\Transactions\Trade\AuctionTransactions;
use Illuminate\Support\Facades\Session;

class AuctionController extends Controller
{
//    /** @var  HeroRepositoryObj */
//    protected $heroRepo;
    /** @var  AuctionRepository */
    protected $auctionRepo;

    /**
     * AuctionController constructor.
     */
    public function __construct(AuctionRepository $auctionRepo, HeroRepositoryObj $heroRepo)
    {
        $this->auctionRepo = $auctionRepo;
        $this->heroRepo = $heroRepo;

        parent::__construct();
    }

    public function index()
    {
        $user_id = \Auth::id();
        $lots = $this->auctionRepo->getActiveLots();

        $hero = $this->heroRepo->findById($user_id);
        $heroThings = $hero->things;

        $thingsForSale = $heroThings->filter(function ($thing) {
            return $thing->status === 'free';
        });

        $expiredLots = $this->auctionRepo->getExpiredLots();
        
        $userJson = json_encode(['id' => $this->user_id, 'name' => auth()->user()->name]);

        return $this->view('trade.auction.auction', [
            'lots' => $lots,
            'heroThings' => $heroThings,
            'thingsForSale' => $thingsForSale,
            'expiredLots' => $expiredLots,
            'userJson' => $userJson,
        ]);
    }

    public function addLot(AuctionAddLotRequest $request)
    {
        $user_id = \Auth::id();
        
        $command = new CreateLotCommand($this->heroRepo);
        
        $command->createLot($request->thing_id, $user_id, $request->bid);

        Session::flash('message', 'Lot is added successfully!');
        return redirect()->route('auction_page');
    }


    public function buy(AuctionBuyLotRequest $request)
    {
        $lot_id = $request->get('lot_id');
        $purchaser_id = \Auth::id();

        $cmd = new CommitPurchasingCommand(new AuctionRepository(), new HeroRepositoryObj());
        $cmd->commitPurchasing($lot_id, $purchaser_id);

        Session::flash('message', 'Lot is bought yet!');

        return redirect()->route('auction_page');
    }
}
