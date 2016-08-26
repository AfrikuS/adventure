<?php

namespace App\Modules\Profile\Controllers;

use App\Commands\Drive\CreateDriverCommand;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Battle\ResourceChannel;
use App\Models\Work\Worker;
use App\Modules\Hero\Persistence\Repositories\BuildingsRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerRepo;
use App\Repositories\Drive\DriverRepository;

class ProfileController extends Controller
{
    public function index()
    {
//        if (null === Worker::find(\Auth::id())) {
//            WorkerFactory::createWorker(\Auth::id());
//        }

        /** @var WorkerRepo $workerRepo */
        $workerRepo = app('WorkerRepo');

        $worker = $workerRepo->findSimpleWorker($this->user_id);
//        $skills = $worker->skills;

        return $this->view('profile.profile', [
//            'workSkills' => $skills
        ]);
    }

    public function channels()
    {
        $user_id = \Auth::id();

        $channels = ResourceChannel::
            select(['id', 'from_user_id', 'to_user_id', 'resource', 'tax_percent'])
            ->where('to_user_id', $user_id)
            ->with(['fromUser' => function ($query) {
                $query->select('id', 'name');
            }])->get();

        $lossChannels = ResourceChannel::
            select(['id', 'from_user_id', 'to_user_id', 'resource', 'tax_percent'])
            ->where('from_user_id', $user_id)
            ->with(['toUser' => function ($query) {
                $query->select('id', 'name');
            }])->get();

        return $this->view('profile.channels', [
            'channels' => $channels,
            'lossChannels' => $lossChannels,
        ]);
    }

    public function buildings()
    {
        /** @var BuildingsRepo $buildings */
        $buildingsRepo = app('BuildingsRepo');

        $buildings = $buildingsRepo->getByHero($this->user_id);
//        $buildings = Buildings::find($this->user_id);

        return $this->view('profile.buildings', [
            'buildings' => $buildings,
        ]);
    }

    public function becomeDriver()
    {
        $cmd = new CreateDriverCommand(new DriverRepository());
        
        $cmd->createDriver($this->user_id);
            
        
        return \Redirect::route('profile_become_driver_action');
    }
}
