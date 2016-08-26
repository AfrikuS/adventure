<?php

namespace App\Modules\Npc\View\Composers;

use App\Modules\Npc\Persistence\Repositories\OffersRepo;
use Illuminate\View\View;

class OffersComposer
{
    /** @var OffersRepo */
    private $offers;

    public function __construct(OffersRepo $offers)
    {
        $this->offers = $offers;
    }

    public function compose(View $view)
    {
        $user_id = $view->offsetGet('user_id');

        $offers = $this->offers->getBy($user_id);

        $view->with('npcOffers', $offers);
    }
}
