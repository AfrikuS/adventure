<?php

namespace App\Http\Controllers\Profile;

use App\Commands\Drive\CreateDriverCommand;
use App\Factories\WorkerFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Battle\ResourceChannel;
use App\Models\Work\Worker;
use App\Repositories\Drive\DriverRepository;
use App\Repositories\Work\Team\WorkerRepository;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function index()
    {
        if (null === Worker::find(\Auth::id())) {
            WorkerFactory::createWorker(\Auth::id());
        }
        
        $worker = WorkerRepository::findWithMaterialsAndSkillsById(\Auth::id());
        $skills = $worker->skills;

        return $this->view('profile.profile', [
            'workSkills' => $skills
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

    public function becomeDriver()
    {
        $cmd = new CreateDriverCommand(new DriverRepository());
        
        $cmd->createDriver($this->user_id);
            
        
        return \Redirect::route('profile_become_driver_action');
    }
}
