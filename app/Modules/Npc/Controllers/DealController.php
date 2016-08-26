<?php

namespace App\Modules\Npc\Controllers;

use App\Entities\Npc\NpcOfferEntity;
use App\Factories\NpcFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Modules\Npc\Actions\PerformDeal;
use App\Modules\Npc\Domain\Entities\NpcDeal;
use App\Modules\Npc\Persistence\Repositories\DealsRepo;
use App\Modules\Npc\Persistence\Repositories\OffersRepo;
use Illuminate\Support\Facades\Input;

class DealController extends Controller
{
    /** @var OffersRepo */
    private $offers;

    /** @var DealsRepo */
    private $deals;

    public function __construct(OffersRepo $offers, DealsRepo $deals)
    {
        parent::__construct();

        $this->offers = $offers;
        $this->deals = $deals;
    }

    public function index($deal_id)
    {
        /** @var  NpcOfferEntity */
//        $npcOfferEntity = $this->npcDealRepo->findOfferById($id);
        $deal = $this->deals->find($deal_id);



        switch ($deal->deal_status) {

            case NpcDeal::STATUS_FINISHED:

                return $this->view('npc.show_reward', [
                    'offer' => $deal,
                ]);

        }

        return $this->view('npc.show_deal', compact('deal'));
    }



    public function performDeal()
    {
        $deal_id = Input::get('deal_id');

        $action = new PerformDeal();

        $action->preform($deal_id);
        
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


}
