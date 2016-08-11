<?php

namespace App\Http\Controllers\Profile;

use App\Commands\Hero\Equipment\OilDistillatorUpgradeCmd;
use App\Commands\Hero\Equipment\PumpOilUpgradeCmd;
use App\Http\Controllers\Controller;
use App\Repositories\Core\Equipment\PumpOilRepo;

class EquipmentController extends Controller
{

    /** @var PumpOilRepo */
    protected $pumpOilRepo;

    public function __construct()
    {
        parent::__construct();

        $this->pumpOilRepo = new PumpOilRepo();
    }

    public function index()
    {

        return $this->view('profile.equipment.index', [
//            'waterStore'     => $pumpOil,
        ]);
    }

    public function buyPumpOil()
    {
        $pumpOilUpgrader = new PumpOilUpgradeCmd($this->pumpOilRepo);

        $pumpOilUpgrader->upgrade($this->user_id);


        return \Redirect::route('profile_resource_stores_page');
    }

    public function upgradePumpOil()
    {
        $pumpOilUpgrader = new PumpOilUpgradeCmd($this->pumpOilRepo);

        try {

            $pumpOilUpgrader->upgrade($this->user_id);

        }
        catch (\Exception $e) {
            \Session::flash('msg', 'Pump Oil max level');
        }


        return \Redirect::route('profile_resource_stores_page');
    }

    public function buyOilDistillator()
    {
        $oilDistillatorUpgrader = new OilDistillatorUpgradeCmd($this->pumpOilRepo);

        $oilDistillatorUpgrader->upgrade($this->user_id);


        return \Redirect::route('profile_resource_stores_page');
    }

    public function upgradeOilDistillator()
    {
        $oilDistillatorUpgrader = new OilDistillatorUpgradeCmd($this->pumpOilRepo);

        try {

            $oilDistillatorUpgrader->upgrade($this->user_id);

        }
        catch (\Exception $e) {
            \Session::flash('msg', 'Oil Distillator max level');
        }


        return \Redirect::route('profile_resource_stores_page');
    }

}
