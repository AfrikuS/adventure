<?php

namespace App\Http\Controllers\Battle;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\ActionTimer;
use App\Repositories\TimerRepository;
use Illuminate\Support\Facades\Auth;

class BodalkaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $timer = TimerRepository::getTimerByActionCode('bodalka', $user->id);

        if ($timer && $timer->duration_seconds < 0) {
            ActionTimer::destroy($timer->id);
            $timer = null;
        }

        return $this->view('mini/bodalka', [
            'timer'  => $timer,
        ]);
    }

    public function start ()
    {
        TimerRepository::addTimer('bodalka', $this->user_id);

        return redirect()->route('bodalka_page');
    }
}
