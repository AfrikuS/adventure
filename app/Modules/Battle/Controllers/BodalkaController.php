<?php

namespace App\Modules\Battle\Controllers;

use App\Jobs\Work\CreateBuildOrderCmd;
use App\Modules\Core\Http\Controller;
use App\Http\Requests;
use App\Models\ActionTimer;
use App\Modules\Hero\Persistence\Repositories\HeroRepo;
use App\Modules\Timer\Exceptions\TimerExpired_Exception;
use App\Modules\Timer\Persistence\Dao\BodalkaResultDao;
use App\Modules\Timer\Persistence\Repositories\TimersRepo;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;

class BodalkaController extends Controller
{
    public function index()
    {
        /** @var TimersRepo $timersRepo */
        $timersRepo = app('TimersRepo');


        $isExistTimer = $timersRepo->isExistBy($this->user_id, 'bodalka');
        
        if (! $isExistTimer) {
            
            return $this->view('battle.bodalka.index', []);
        }

        $timer = $timersRepo->findBy($this->user_id, 'bodalka');

        if ($timer->isActive()) {

            return $this->view('battle.bodalka.waiting', [
                'timer'  => $timer,
            ]);
        }
        else {

            $resultDao = new BodalkaResultDao();
            $result = $resultDao->findBy($this->user_id);

            /** @var HeroRepo $heroRepo */
            $heroRepo = app('HeroRepo');
            $hero = $heroRepo->getHero($this->user_id);

            $hero->incrementOil($result->oil);
            $hero->incrementGold($result->gold);



            \DB::beginTransaction();
            $heroRepo->updateResources($hero);
            $resultDao->delete($this->user_id);
            $timersRepo->delete($timer);
            \DB::commit();

            return $this->view('battle.bodalka.index', []);
        }
    }

    public function startWalking ()
    {
        /** @var TimersRepo $timersRepo */
        $timersRepo = app('TimersRepo');

        $seconds = 10;
        $timersRepo->addTimer($this->user_id, 'bodalka', $seconds);



        $job = new CreateBuildOrderCmd($this->user_id);
        $b = $this->dispatch($job);


        return \Redirect::route('bodalka_page');
    }
}
