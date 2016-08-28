<?php

namespace App\Http\Controllers\Drive\Raid;

use App\Commands\Drive\Raid\Robbery\FinishRobberyCommand;
use App\Entities\Drive\RobberyEntity;
use App\Models\Core\Hero;
use App\Repositories\Drive\DriverRepository;
use App\Repositories\Drive\RaidRepository;
use Illuminate\Support\Facades\Redirect;

class RobberyController extends RaidController
{
    /** @var RobberyEntity */
    protected $robbery;

    /** @var Hero */
    protected $victim;

    public function __construct(DriverRepository $driverRepo, RaidRepository $raidRepo)
    {
        parent::__construct($driverRepo, $raidRepo);

        $this->robbery = $this->raidRepo->findRobberyByDriverId($this->driver->id);

        $victim_id = $this->robbery->victim_id;

        $this->victim = $this->heroRepo->findHeroWithBuildings($victim_id);
    }

    public function show()
    {

        $victimBuildings = $this->victim->getRelation('buildings');

        $status = $this->robbery->robbery_status;

        switch ($status) {
            case 'far_gates':

                return $this->view('drive.raid.robbery.gates_far', [
                ]);

            case 'detailed_view_gates':  // больше инфы о жилище\постройках


                return $this->view('drive.raid.robbery.detail_view_gates', [
                ]);

            case 'gates': // выбор действий при взломе ворот

                return $this->view('drive.raid.robbery.gates_near', [
                    'gates_durability' => $victimBuildings->gates_level,
                ]);

            case 'fence':  // забор, выбор действий

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
        $this->robbery->detailedViewOnGates();

        return \Redirect::route('drive_robbery_page');
    }

//    public function driveToGates()
//    {
//        $this->robbery->driveToGates();
//
//        return \Redirect::route('drive_robbery_page');
//    }




//    public function driveInHouse()  // въехать в жилище
//    {
//        $this->robbery->driveInHouse();
//
//        return \Redirect::route('drive_robbery_page');
//    }
//
//    public function driveInAmbar()  // въехать в амбар
//    {
//        $this->robbery->driveInAmbar();
//
//        return \Redirect::route('drive_robbery_page');
//    }
//
//    public function driveInWarehouse() // въехать в склад ресурсов
//    {
//        $this->robbery->driveInWarehouse();
//
//        return \Redirect::route('drive_robbery_page');
//    }

    public function finish()
    {

        $cmd = new FinishRobberyCommand($this->raidRepo);

        $cmd->finishRobbery($this->robbery);


        return Redirect::route('drive_raid_page');
    }

    public function abort()
    {
        
        $cmd = new FinishRobberyCommand($this->raidRepo);
        
        $cmd->finishRobbery($this->robbery);
        
        

        \Session::flash('message', 'Вы неожиданно прервали разбой');

        return \Redirect::route('drive_raid_page');
    }


}