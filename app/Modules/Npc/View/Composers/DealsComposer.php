<?php

namespace App\Modules\Npc\View\Composers;

use App\Modules\Npc\Persistence\Repositories\DealsRepo;
use Illuminate\View\View;

class DealsComposer
{
    /** @var DealsRepo */
    private $deals;

    public function __construct(DealsRepo $deals)
    {
        $this->deals = $deals;
    }

    public function compose(View $view)
    {
        $user_id = $view->offsetGet('user_id');

        $deals = $this->deals->getBy($user_id);

        $view->with('npcDeals', $deals);
    }
}
