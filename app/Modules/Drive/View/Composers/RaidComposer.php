<?php

namespace App\Modules\Drive\View\Composers;

use App\Modules\Drive\Persistence\Repositories\Raid\RaidsRepo;
use Illuminate\View\View;

class RaidComposer
{
    /** @var RaidsRepo */
    private $raidsRepo;

    public function __construct(RaidsRepo $raidsRepo)
    {
        $this->raidsRepo = $raidsRepo;
    }

    public function compose(View $view)
    {
        $driver_id = $view->offsetGet('user_id');

        $raid = $this->raidsRepo->findByDriver($driver_id);

        $view->with('raid', $raid);
    }
}
