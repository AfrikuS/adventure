<?php

namespace App\Commands\Npc;

use App\Repositories\Npc\OfferRepository;
use App\StateMachines\Npc\OfferStateMachine;

class OfferAcceptCommand
{
    private $commandValidator;
    private $commandContext = [];

    /**
     * OfferAcceptCommand constructor.
     */
    public function __construct(OfferAcceptValidator $valudator, int $offer_id)
    {
        $this->commandValidator = $valudator;
        $this->commandContext = [
            'offer_id' => $offer_id,
        ];
    }

    public function execute()
    {
        $offer_id = $this->commandContext['offer_id'];
        $offerData = OfferRepository::findById($offer_id);
        $offerState = new OfferStateMachine($offerData);
        
        if (!$offerState->state === 'shown') {
            return false;
        }

        if ($this->commandValidator->validate()) {
            $offerState->accept();
        }
    }
}
