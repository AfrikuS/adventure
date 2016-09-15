<?php

namespace App\Modules\Drive\Controllers\Garage;

use App\Modules\Core\Http\Controller;
use App\Modules\Drive\Actions\Garage\RecoveryVehicleAction;
use App\Modules\Drive\Actions\Garage\RefuelVehicleAction;
use App\Modules\Drive\Actions\Garage\RepairVehicleAction;
use App\Modules\Drive\Actions\Garage\Workroom\RefuelerUpgradeAction;
use App\Modules\Drive\Actions\Garage\Workroom\RepairerUpgradeAction;
use App\Modules\Drive\Persistence\Repositories\VehiclesRepo;
use App\Modules\Drive\Persistence\Repositories\Workroom\RefuelerRepo;
use App\Modules\Drive\Persistence\Repositories\Workroom\RepairerRepo;
use Illuminate\Support\Facades\Redirect;

class WorkroomController extends Controller
{
    public function index()
    {
        /** @var VehiclesRepo $vehicleRepo */
        $vehicleRepo = app('DriveVehiclesRepo');
        $vehicle = $vehicleRepo->findActiveByDriver($this->user_id);

//        /** @var EquipmentsRepo $equipmentsRepo */
//        $equipmentsRepo = app('DriveEquipmentsRepo');
//
//        $equipmentsRepo->createBy($this->user_id);

        
        /** @var RefuelerRepo $refuelerRepo */
        $refuelerRepo = app('RefuelerRepo');
        $refueler = $refuelerRepo->findBy($this->user_id);


        /** @var RepairerRepo $repairerRepo */
        $repairerRepo = app('RepairerRepo');
        $repairer = $repairerRepo->findBy($this->user_id);


        return $this->view('drive.garage.workroom.index', [
            'vehicle' => $vehicle,
            'refueler'     => $refueler,
            'repairer'     => $repairer,
        ]);
    }

    public function buyRefueler()
    {
        $pumpOilUpgrader = new RefuelerUpgradeAction();

        $pumpOilUpgrader->upgrade($this->user_id);


        return \Redirect::route('drive_workroom_page');
    }

    public function upgradeRefueler()
    {
        $pumpOilUpgrader = new RefuelerUpgradeAction();

        try {

            $pumpOilUpgrader->upgrade($this->user_id);

        }
        catch (\Exception $e) {
            \Session::flash('msg', 'Refueler max level');
        }


        return \Redirect::route('drive_workroom_page');
    }

    public function refuel()
    {
        $refuelAction = new RefuelVehicleAction();

        $refuelAction->refuel($this->user_id);


        return Redirect::route('drive_workroom_page');
    }
    
    public function buyRepairer()
    {
        $repairerUpgradeAction = new RepairerUpgradeAction();

        $repairerUpgradeAction->upgrade($this->user_id);


        return \Redirect::route('drive_workroom_page');
    }

    public function upgradeRepairer()
    {
        $repairerUpgradeAction = new RepairerUpgradeAction();

        try {

            $repairerUpgradeAction->upgrade($this->user_id);

        }
        catch (\Exception $e) {
            \Session::flash('msg', 'Repairer max level');
        }


        return \Redirect::route('drive_workroom_page');
    }

    public function repair()
    {
        $repair = new RepairVehicleAction();

        $repair->repair($this->user_id);


        return Redirect::route('drive_workroom_page');
    }



    /*    public function buyRepairer()
        {
            $oilDistillatorUpgrader = new OilDistillerUpgradeAction();
    
            $oilDistillatorUpgrader->upgrade($this->user_id);
    
    
            return \Redirect::route('profile_resource_stores_page');
        }
    
        public function upgradeRepairer()
        {
            $oilDistillatorUpgrader = new OilDistillerUpgradeAction();
    
            try {
    
                $oilDistillatorUpgrader->upgrade($this->user_id);
    
            }
            catch (\Exception $e) {
                \Session::flash('msg', 'Oil Distillator max level');
            }
    
    
            return \Redirect::route('profile_resource_stores_page');
        }*/

    public function recovery()
    {
        
        $recoveryVehicleAction = new RecoveryVehicleAction();

        $recoveryVehicleAction->recovery($this->user_id);

        

        return Redirect::route('drive_workroom_page');
    }

}
