<?php

namespace App\Modules\Npc\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Npc\Actions\GenerateNpcOffer;
use App\Modules\Npc\Actions\NpcOfferAcceptCommand;
use App\Modules\Npc\Actions\NpcOfferRefuseCommand;
use App\Modules\Npc\Domain\Entities\NpcOffer;
use App\Modules\Npc\Domain\Services\OfferService;
use App\Modules\Npc\Persistence\Repositories\OffersRepo;
use Carbon\Carbon;
use Finite\Exception\StateException;
use Illuminate\Support\Facades\Input;

class OfferController extends Controller
{
    /** @var OffersRepo */
    private $offers;

    public function __construct()
    {
        parent::__construct();

        $this->offers = app('OffersRepo');
    }

    public function index($offer_id)
    {
        /** @var NpcOffer $offer */
        $offer = $this->offers->find($offer_id);

        $offerService = new OfferService();
        
        switch ($offer->offer_status) 
        {
            case NpcOffer::STATUS_CREATED:

                $offerService->activateOfferTimer($offer);
                
                return $this->view('npc.show_offer', [
                    'offer' => $offer,
                ]);
            
            case NpcOffer::STATUS_ACCEPTED:

                return \Redirect::route('npc_show_deal_page', ['deal_id' => $offer_id]);
                
            case NpcOffer::STATUS_EXPIRED:

                $offerService->cancelOffer($offer);

                return $this->view('npc.show_offer_expired');

            case NpcOffer::STATUS_SHOWN:
                
                if ($offer->isOfferExpired()) {

//                    $offerService->updateStatusAfterExpire($offer);

                    $offerService->cancelOffer($offer);

                    return $this->view('npc.show_offer_expired');
//                    return \Redirect::refresh();
                }

                return $this->view('npc.show_offer', [
                    'offer' => $offer,
                ]);
        }
    }


    public function acceptOffer()
    {
        $offer_id = Input::get('offer_id');

        $command = new NpcOfferAcceptCommand();

        try {

            $command->acceptOffer($offer_id, $this->user_id);
        }
        catch (StateException $e) {

            return \Redirect::route('npc_show_offer_page', [$offer_id]);
        }

        return \Redirect::route('npc_show_deal_page', ['id' => $offer_id]);
    }

    public function refuseOffer()
    {
        $offer_id = Input::get('offer_id');

        $command = new NpcOfferRefuseCommand();

        $command->refuseOffer($offer_id);


        return \Redirect::route('profile_page');
    }

    public function generateOffer()
    {
        $action = new GenerateNpcOffer();

        $action->generate($this->user_id);

        return \Redirect::back();
    }
}
