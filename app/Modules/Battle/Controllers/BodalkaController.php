<?php

namespace App\Modules\Battle\Controllers;

use App\Modules\Core\Http\Controller;
use App\Http\Requests;
use App\Models\ActionTimer;
use App\Modules\Timer\Exceptions\TimerExpired_Exception;
use App\Modules\Timer\Persistence\Repositories\TimersRepo;

class BodalkaController extends Controller
{
    public function index()
    {
        /** @var TimersRepo $timersRepo */
        $timersRepo = app('TimersRepo');


        try {

            $timer = $timersRepo->findBy($this->user_id, 'bodalka');
        }
        catch (TimerExpired_Exception $e) {

            return $this->view('battle.bodalka.index', []);
        }

        if ($timer->isActive()) {

            return $this->view('battle.bodalka.waiting', [
                'timer'  => $timer,
            ]);
        }
        else {

            $timersRepo->delete($timer);

            return $this->view('battle.bodalka.index', []);
        }
    }

    public function startWalking ()
    {
        /** @var TimersRepo $timersRepo */
        $timersRepo = app('TimersRepo');

        $seconds = 13;
        $timersRepo->addTimer($this->user_id, 'bodalka', $seconds);


        return \Redirect::route('bodalka_page');
    }
}
