<?php

namespace App\Modules\Work\View\Composers;

use App\Modules\Work\Persistence\Repositories\Worker\WorkerRepo;
use Illuminate\View\View;

class WorkerComposer
{
    /** @var WorkerRepo */
    private $workerRepo;

    public function __construct(WorkerRepo $workerRepo)
    {
        $this->workerRepo = $workerRepo;
    }

    public function compose(View $view)
    {
        $user_id = $view->offsetGet('user_id');


        $worker = $this->workerRepo->findSimpleWorker($user_id);

        $view->with('worker', $worker);
    }
}
