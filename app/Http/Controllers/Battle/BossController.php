<?php

namespace App\Http\Controllers\Battle;

use App\Deleters\BattleDeleter;
use App\Domain\MassActions;
use App\Domain\State\StateBoss;
use App\Factories\BattleFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\MassBossJoinRequest;
use App\Repositories\Battle\BossRepository;
use App\Repositories\Battle\BossTimerRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class BossController extends Controller
{
    public function index()
    {
            $userId = auth()->user()->id;

            $boss = BossRepository::getBossByUserId($userId);

            $stateDefiner = new StateBoss($userId);
            $state = $stateDefiner->getCurrentState();

            switch ($state) {
                case 'BOSS_END': {
                    $workers = BossRepository::getUsers($boss->id);

                    BattleDeleter::deleteBoss($boss);

                    return $this->view('battle.boss.boss_end', [
                        'mass_work' => $boss,
                        'workers'   => $workers,
                    ]);

                }
                case 'BOSS_PROCESS': {
                    $timer = BossTimerRepository::getTimerBoss($boss->id);
                    $workers = BossRepository::getUsers($boss->id);

                    return $this->view('battle.boss.boss_process', [
                        'timer'   => $timer,
                        'workers' => $workers,
                        'boss'    => $boss,
                    ]);
                }
                case 'NO_BOSS': {
                    $bosses = BossRepository::getAll();


                    return $this->view('battle.boss.index', [
                        'bosses' => $bosses,
                    ]);
                }
                default: {
                    // ERROR_UNKNOWN_STATE
//                    die('boss');
                    break;
                }
            }
    }

    public function boss_create()
    {
        BattleFactory::createBoss(\Auth::user());
        return redirect()->route('boss_page');
    }

    public function boss_join(MassBossJoinRequest $request)
    {
        $bossId = Input::get('boss_id');
        MassActions::joinToBoss($bossId);

        return redirect('/boss');
    }

    public function boss_kick()
    {
        $userId = Auth::user()->id;
        BossRepository::addKick($userId);
        return redirect()->route('boss_page');
    }

}
