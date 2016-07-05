<?php

namespace App\Commands\Npc;

use App\Models\Npc\NpcDeal;
use App\StateMachines\Npc\OfferStateMachine;

class OfferRefuseCommand
{
    private $commandContext = [];

    /**
     * OfferAcceptCommand constructor.
     */
    public function __construct(int $offer_id)
    {
        $this->commandContext = [
            'offer_id' => $offer_id,
        ];
    }

    public function execute()
    {
        $offer_id = $this->commandContext['offer_id'];
        $offer = NpcDeal::find($offer_id);

        $offerSM = new OfferStateMachine($offer);
        $offerSM->refuse();
        
    }
}
