<?php

namespace App\Modules\Dozor\Http\Controllers;

use App\Modules\Core\Http\Controller;
use App\Modules\Dozor\Domain\Entities\DozorQuest;
use App\Modules\Dozor\Http\Requests\DozorStartQuestRequest;
use App\Modules\Dozor\Persistence\Repositories\DozorRepo;
use App\Modules\Hero\Domain\Commands\Resources\IncrementGold;
use Carbon\Carbon;
use Illuminate\Support\Facades\Bus;

class DozorController extends Controller
{
    /** @var  DozorRepo */
    protected $dozorRepo;

    public function __construct(DozorRepo $dozorRepo)
    {
        $this->dozorRepo = $dozorRepo;

        parent::__construct();
    }

    public function index()
    {
//        $users = app('UsersRepo');
        
        $quest = $this->dozorRepo->findDozorQuest($this->user_id);


        switch ($quest->status) {

            case DozorQuest::FREE:

                return $this->view('dozor.free', [
                ]);


            case DozorQuest::BUSY:

                $time = $quest->time;
                
                return $this->view('dozor.busy', [
                    'uptime' => $time,
                ]);

            case DozorQuest::PRIZE:

                $questPrize = 100;

                $takeQuestPrize = new IncrementGold($this->user_id, $questPrize);

                Bus::dispatch($takeQuestPrize);


                $this->dozorRepo->updateAfterFinishQuest($this->user_id);
                
                return $this->view('dozor.prize', [
                    'prize' => $questPrize,
                ]);
        }


        return \Redirect::route('work_orders_page');

//
//        $user = $users->find($this->user_id);
//
//        $userJson = json_encode(['id' => $user->id, 'name' => $user->name]);

    }

//    public function index()
//    {
//        /** @var TimersRepo $timersRepo */
//        $timersRepo = app('TimersRepo');
//
//
//        $isExistTimer = $timersRepo->isExistBy($this->user_id, 'bodalka');
//
//        if (! $isExistTimer) {
//
//            return $this->view('battle.bodalka.index', []);
//        }
//
//        $timer = $timersRepo->findBy($this->user_id, 'bodalka');
//
//        if ($timer->isActive()) {
//
//            return $this->view('battle.bodalka.waiting', [
//                'timer'  => $timer,
//            ]);
//        }
//        else {
//
//            $resultDao = new BodalkaResultDao();
//            $result = $resultDao->findBy($this->user_id);
//
//            /** @var HeroRepo $heroRepo */
//            $heroRepo = app('HeroRepo');
//            $hero = $heroRepo->getHero($this->user_id);
//
//            $hero->incrementOil($result->oil);
//            $hero->incrementGold($result->gold);
//
//
//
//            \DB::beginTransaction();
//            $heroRepo->updateResources($hero);
//            $resultDao->delete($this->user_id);
//            $timersRepo->delete($timer);
//            \DB::commit();
//
//            return $this->view('battle.bodalka.index', []);
//        }
//    }

    public function startDozorQuest(DozorStartQuestRequest $request)
    {
        $seconds = 5;
        $timerStr = Carbon::create()->addSeconds($seconds)->toDateTimeString();

        $this->dozorRepo->updateAfterStartitQuest($this->user_id, $timerStr);


//        /** @var TimersRepo $timersRepo */
//        $timersRepo = app('TimersRepo');
//
//        $seconds = 10;
//        $timersRepo->addTimer($this->user_id, 'bodalka', $seconds);
//
//
//
//        $job = new CreateBuildOrderCmd($this->user_id);
//        $b = $this->dispatch($job);
//

//        $command = new CalculateQuestTimeCommand();
//
//        $command->createLot($request->thing_id, $this->user_id, $request->bid);

//        Session::flash('message', 'Lot is added successfully!');

        return \Redirect::route('dozor_index_page');
    }

}
