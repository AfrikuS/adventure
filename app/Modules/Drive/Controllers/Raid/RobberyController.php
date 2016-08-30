<?php

namespace App\Modules\Drive\Controllers\Raid;

use App\Models\Core\Hero;
use App\Modules\Drive\Actions\Raid\Robbery\FinishRobberyCommand;
use App\Modules\Drive\Domain\Services\Raid\RobberyService;
use App\Modules\Drive\Persistence\Repositories\Raid\RobberyRepo;
use App\Modules\Hero\Domain\Entities\Buildings;
use Illuminate\Support\Facades\Redirect;

class RobberyController extends RaidController
{
    /** @var RobberyRepo */
    protected $robberyRepo;

    /** @var Hero */
    protected $victim;

    public function __construct()
    {
        parent::__construct();

        $this->robberyRepo = app('DriveRobberyRepo');
    }

    public function show()
    {

        $buildingsRepo = app('BuildingsRepo');

        /** @var Buildings $victimBuildings */
        $victimBuildings = $buildingsRepo->getByHero($this->user_id);

        $robbery = $this->robberyRepo->findRobbery($this->user_id);

        switch ($robbery->robbery_status) {

            case 'far_gates':

                return $this->view('drive.raid.robbery.gates_far', [
                ]);

            case 'detailed_view_gates':  // больше инфы о жилище\постройках


                return $this->view('drive.raid.robbery.detail_view_gates', [
                ]);

            case RobberyService::ROBBERY_STATUS_GATES: //'gates': // выбор действий при взломе ворот

                return $this->view('drive.raid.robbery.gates_near', [
                    'gates_durability' => $victimBuildings->gatesLevel,
                ]);

            case RobberyService::ROBBERY_STATUS_FENCE: //'fence':  // забор, выбор действий

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
