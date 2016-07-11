<?php

namespace App\Http\Controllers\Npc;

use App\Commands\Npc\DemonstrateNpcOfferCommand;
use App\Commands\Npc\NpcOfferAcceptCommand;
use App\Commands\Npc\NpcOfferRefuseCommand;
use App\Entities\Npc\NpcOfferEntity;
use App\Exceptions\TooLongNpcOfferWaitingException;
use App\Factories\NpcFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Repositories\Npc\NpcDealRepository;
use Illuminate\Support\Facades\Input;

class NpcDealController extends Controller
{
    /** @var  NpcDealRepository */
    private $npcDealRepo;

    /**
     * NpcDealController constructor.
     * @param NpcDealRepository $npcDealRepo
     */
    public function __construct(NpcDealRepository $npcDealRepo)
    {
        $this->npcDealRepo = $npcDealRepo;
        
        parent::__construct();
    }

    public function showOffer($id)
    {
        /** @var  NpcOfferEntity */
        $npcOfferEntity = $this->npcDealRepo->findOfferById($id);


        try {
            $cmd = new DemonstrateNpcOfferCommand($this->npcDealRepo);

            $cmd->demonstrateOffer($npcOfferEntity);
            
        }
        catch (TooLongNpcOfferWaitingException $e)
        {
            return $this->view('npc.show_offer_expired', [
                'offer' => $npcOfferEntity,
            ]);
        }
        
        return $this->view('npc.show_offer', [
            'offer' => $npcOfferEntity,
        ]);
    }

    public function acceptOffer()
    {
        $offer_id = Input::get('offer_id');
        
        $command = new NpcOfferAcceptCommand($this->npcDealRepo);

        $command->acceptOffer($offer_id);

        return \Redirect::route('npc_show_deal_page', ['id' => $offer_id]);
    }

    public function refuseOffer()
    {
        $offer_id = Input::get('offer_id');
        
        $command = new NpcOfferRefuseCommand($this->npcDealRepo);

        $command->refuseOffer($offer_id);


        return \Redirect::route('profile_page');
    }

    public function showDeal($id)
    {
        $deal = $this->npcDealRepo->findDealEntityById($id);

        return $this->view('npc.show_deal', [
            'offer' => $deal,
        ]);
    }

    public function performDeal()
    {
        $deal_id = Input::get('deal_id');

        $deal = $this->npcDealRepo->findDealEntityById($deal_id);

        $deal->performTask();

        return \Redirect::route('npc_show_deal_page', ['id' => $deal_id]);
    }

    public function showReward($id)
    {
        $deal = $this->npcDealRepo->findDealEntityById($id);

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
