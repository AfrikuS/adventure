<?php

namespace App\Modules\Hero\View\Composers;

use App\Modules\Hero\Persistence\Repositories\HeroRepo;
use Illuminate\View\View;

class ResourcesComposer
{
    /** @var HeroRepo */
    private $heroRepo;

    public function __construct(HeroRepo $heroRepo)
    {
        $this->heroRepo = $heroRepo;
    }

    public function compose(View $view)
    {
        $user_id = $view->offsetGet('user_id');


        $hero = $this->heroRepo->getHero($user_id);

        $view->with('hero', $hero);
    }
}
