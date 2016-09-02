<?php

namespace App\Modules\Profile\Controllers;

use App\Commands\Hero\Equipment\OilDistillatorUpgradeAction;
use App\Commands\Hero\Equipment\PumpOilUpgradeAction;
use App\Modules\Core\Http\Controller;
use App\Repositories\Core\Equipment\OilPumpRepo;

class EquipmentController extends Controller
{

    /** @var OilPumpRepo */
    protected $pumpOilRepo;

    public function __construct()
    {
        parent::__construct();

        $this->pumpOilRepo = new OilPumpRepo();
    }

    public function index()
    {

        return $this->view('profile.equipment.index', [
//            'waterStore'     => $pumpOil,
        ]);
    }

    public function buyPumpOil()
    {
        $pumpOilUpgrader = new PumpOilUpgradeAction($this->pumpOilRepo);

        $pumpOilUpgrader->upgrade($this->user_id);


        return \Redirect::route('profile_resource_stores_page');
    }

    public function upgradePumpOil()
    {
        $pumpOilUpgrader = new PumpOilUpgradeAction($this->pumpOilRepo);

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
        $oilDistillatorUpgrader = new OilDistillatorUpgradeAction($this->pumpOilRepo);

        $oilDistillatorUpgrader->upgrade($this->user_id);


        return \Redirect::route('profile_resource_stores_page');
    }

    public function upgradeOilDistillator()
    {
        $oilDistillatorUpgrader = new OilDistillatorUpgradeAction($this->pumpOilRepo);

        try {

            $oilDistillatorUpgrader->upgrade($this->user_id);

        }
        catch (\Exception $e) {
            \Session::flash('msg', 'Oil Distillator max level');
        }


        return \Redirect::route('profile_resource_stores_page');
    }

}
