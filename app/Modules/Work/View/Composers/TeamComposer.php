<?php

namespace App\Modules\Work\View\Composers;

use App\Modules\Work\Persistence\Repositories\Team\TeamRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerRepo;
use Illuminate\View\View;

class TeamComposer
{
    /** @var TeamRepo */
    private $teams;

    /** @var WorkerRepo */
    private $workers;

    public function __construct(TeamRepo $teams, WorkerRepo $workers)
    {
        $this->teams = $teams;
        $this->workers = $workers;
    }

    public function compose(View $view)
    {
        $user_id = $view->offsetGet('user_id');

        $worker = $this->workers->findSimpleWorker($user_id);


        $partners = $this->teams->getPartners($worker->team_id);



        $view->with('partners', $partners);
    }
}
