<?php

namespace App\Modules\Profile\Controllers;

use App\Modules\Core\Http\Controller;
use App\Modules\Oil\Actions\Equipment\OilDistillerUpgradeAction;
use App\Modules\Oil\Actions\Equipment\OilPumpUpgradeAction;
use App\Modules\Oil\Persistence\Repositories\OilPumpRepo;

class EquipmentController extends Controller
{
    public function index()
    {

        return $this->view('profile.equipment.index', [
//            'waterStore'     => $pumpOil,
        ]);
    }

    public function buyPumpOil()
    {
        $pumpOilUpgrader = new OilPumpUpgradeAction();

        $pumpOilUpgrader->upgrade($this->user_id);


        return \Redirect::route('profile_resource_stores_page');
    }

    public function upgradePumpOil()
    {
        $pumpOilUpgrader = new OilPumpUpgradeAction();

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
        $oilDistillatorUpgrader = new OilDistillerUpgradeAction();

        $oilDistillatorUpgrader->upgrade($this->user_id);


        return \Redirect::route('profile_resource_stores_page');
    }

    public function upgradeOilDistillator()
    {
        $oilDistillatorUpgrader = new OilDistillerUpgradeAction();

        try {

            $oilDistillatorUpgrader->upgrade($this->user_id);

        }
        catch (\Exception $e) {
            \Session::flash('msg', 'Oil Distillator max level');
        }


        return \Redirect::route('profile_resource_stores_page');
    }

}
