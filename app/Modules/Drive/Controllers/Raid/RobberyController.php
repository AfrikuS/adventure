<?php

namespace App\Modules\Drive\Controllers\Raid;

use App\Modules\Drive\Actions\Raid\Robbery\FinishRobberyCommand;
use App\Modules\Drive\Domain\Entities\Raid\Robbery;
use App\Modules\Drive\Persistence\Repositories\Raid\RobberiesRepo;
use App\Modules\Hero\Domain\Entities\Buildings;
use Illuminate\Support\Facades\Redirect;

class RobberyController extends RaidController
{
    public function show()
    {
        $buildingsRepo = app('BuildingsRepo');

        $robberyRepo = app('DriveRobberyRepo');

        /** @var Robbery $robbery */
        $robbery = $robberyRepo->findByRaid($this->user_id);

        /** @var Buildings $victimBuildings */
        $victimBuildings = $buildingsRepo->getByHero($robbery->victim_id);




        switch ($robbery->status) {

            case 'far_gates':

                return $this->view('drive.raid.robbery.gates_far', [
                ]);

            case 'detailed_view_gates':  // больше инфы о жилище\постройках


                return $this->view('drive.raid.robbery.detail_view_gates', [
                ]);

            case Robbery::STATUS_GATES: //'gates': // выбор действий при взломе ворот

                return $this->view('drive.raid.robbery.gates_near', [
                    'gates_durability' => $victimBuildings->gatesLevel,
                ]);

            case Robbery::STATUS_FENCE: //'fence':  // забор, выбор действий

                return $this->view('drive.raid.robbery.fence_near', [
                ]);

            case 'courtyard':  // после забора - 3 двери, выбор действий

                return $this->view('drive.raid.robbery.courtyard', [
                ]);

            case 'house':

                return $this->view('drive.raid.robbery.house', [
                ]);

            case 'ambar':

                return $this->view('drive.raid.robbery.ambar', [
                ]);

            case 'warehouse':

                return $this->view('drive.raid.robbery.warehouse', [
                ]);

            case 'final':

//                $query = robberyReport($this->robbery);


                return $this->view('drive.raid.robbery.final', [
                    'report' => 'ROBBERY REPORT'
                ]);
        }

        // order not accepted, free
        throw new \Exception;
    }

    public function detailViewGates()
    {
//        $this->robbery->detailedViewOnGates();

        return \Redirect::route('drive_robbery_page');
    }

    public function finish()
    {

        $cmd = new FinishRobberyCommand();

        $cmd->finishRobbery($this->user_id);


        return Redirect::route('drive_raid_page');
    }

    public function abort()
    {
        
        $cmd = new FinishRobberyCommand();
        
        $cmd->finishRobbery($this->user_id);
        
        

        \Session::flash('message', 'Вы неожиданно прервали разбой');

        return \Redirect::route('drive_raid_page');
    }
}
