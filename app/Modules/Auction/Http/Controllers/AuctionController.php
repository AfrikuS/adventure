<?php

namespace App\Modules\Auction\Http\Controllers;

use App\Modules\Core\Http\Controller;
use App\Http\Requests;
use App\Modules\Auction\Actions\CancelAuctionLot;
use App\Modules\Auction\Actions\CommitPurchasingCommand;
use App\Modules\Auction\Actions\CreateLotCommand;
use App\Modules\Auction\Http\Requests\AuctionAddLotRequest;
use App\Modules\Auction\Http\Requests\AuctionBuyLotRequest;
use App\Modules\Auction\Persistence\Repositories\AuctionRepo;
use App\Repositories\HeroRepositoryObj;
use Illuminate\Support\Facades\Session;

class AuctionController extends Controller
{
//    /** @var  HeroRepositoryObj */
    protected $heroRepo;
    /** @var  AuctionRepo */
    protected $auctionRepo;

    /**
     * AuctionController constructor.
     */
    public function __construct(AuctionRepo $auctionRepo, HeroRepositoryObj $heroRepo)
    {
        $this->auctionRepo = $auctionRepo;
        $this->heroRepo = $heroRepo;

        parent::__construct();
    }

    public function index()
    {
//        $user_id = \Auth::id();
        $lots = $this->auctionRepo->getActiveLots();

//        $hero = $this->heroRepo->findById($user_id);

        $heroThings = $this->auctionRepo->getThingsBy($this->user_id);
        $thingsForSale = $this->auctionRepo->getThingsForSale($this->user_id);

        $expiredLots = $this->auctionRepo->getExpiredLots();

        $users = app('UsersRepo');

        $user = $users->find($this->user_id);
        
        $userJson = json_encode(['id' => $user->id, 'name' => $user->name]);

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
        
        $command = new CreateLotCommand();
        
        $command->createLot($request->thing_id, $this->user_id, $request->bid);

//        Session::flash('message', 'Lot is added successfully!');

        return \Redirect::route('auction_page');
    }


    public function buy(AuctionBuyLotRequest $request)
    {
        $lot_id = $request->get('lot_id');
//        $purchaser_id = \Auth::id();

        $cmd = new CommitPurchasingCommand();
        
        $cmd->commitPurchasing($lot_id, $this->user_id);

//        Session::flash('message', 'Lot is bought yet!');

        return \Redirect::route('auction_page');
    }

    public function cancel($lot_id)
    {
        $action = new CancelAuctionLot();

        $action->cancelLot($lot_id);


        return \Redirect::route('auction_page');
    }
}
