<?php

namespace App\Http\Controllers\Npc;

use App\Commands\Npc\OfferAcceptCommand;
use App\Commands\Npc\OfferAcceptValidator;
use App\Commands\Npc\OfferRefuseCommand;
use App\Factories\NpcFactory;
use App\Models\Npc\NpcDeal;
use App\Repositories\Npc\OfferRepository;
use App\StateMachines\Npc\DealStateMachine;
use App\StateMachines\Npc\OfferStateMachine;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class NpcDealController extends Controller
{
    public function showOffer($id)
    {
        $offer = OfferRepository::findById($id);

        $offerSM = new OfferStateMachine($offer);
        $offerSM->show();
        
        if ($offer->isOfferExpired()) {
            $offerSM->tooLongWait();

            return $this->view('npc.show_offer_expired', [
                'offer' => $offer,
            ]);
        }

        return $this->view('npc.show_offer', [
            'offer' => $offer,
        ]);
    }

    public function acceptOffer()
    {
        $offer_id = Input::get('offer_id');
        $command = new OfferAcceptCommand(new OfferAcceptValidator(), $offer_id);

        $command->execute();
//        $offer = OfferRepository::findById($offer_id);
//
//        $offerSM = new OfferStateMachine($offer);
//        if ($offerSM->state === 'shown') {
//            $offerSM->accept();
//        }

        return \Redirect::route('npc_show_deal_page', ['id' => $offer_id]);
    }

    public function refuseOffer()
    {
        $offer_id = Input::get('offer_id');
        $command = new OfferRefuseCommand($offer_id);

        $command->execute();


        return \Redirect::route('profile_page');
    }

    public function showDeal($id)
    {
        $deal = NpcDeal::find($id);

        return $this->view('npc.show_deal', [
            'offer' => $deal,
        ]);
    }

    public function performDeal()
    {
        $deal_id = Input::get('deal_id');
        $deal = NpcDeal::find($deal_id);

        $dealSM = new DealStateMachine($deal);
        $dealSM->performTask();

        return \Redirect::route('npc_show_deal_page', ['id' => $deal_id]);
    }

    public function showReward($id)
    {
        $deal = NpcDeal::find($id);

        return $this->view('npc.show_reward', [
            'offer' => $deal,
        ]);
    }

    public function takeReward()
    {

    }

    public function generateOffer()
    {
        NpcFactory::createNpcDeal(\Auth::user());
        return \Redirect::back();
    }
}
