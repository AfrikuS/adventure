<?php

namespace App\Modules\Oil\Http\Controllers\Profile\Base;

use App\Http\Controllers\Controller;
use App\Modules\Oil\Domain\Entities\OilDistiller;
use App\Modules\Oil\Persistence\Repositories\OilDistillerRepo;

class OilDistillerController extends Controller
{
    public function index()
    {
        /** @var OilDistillerRepo $oilDistillerRepo */
        $oilDistillerRepo = app('OilDistillerRepo');

        /** @var OilDistiller $oilDistiller */
        $oilDistiller = $oilDistillerRepo->findBy($this->user_id);


        return $this->view('oil.profile.base.oilpump', [
            'oilDistiller' => $oilDistiller,
        ]);
    }

    public function process()
    {
        $oilDistillerProcess = new OilDistillerProcessAction();

        $oilDistillerProcess->process($this->user_id);


        return \Redirect::route('base_oilpump_page');
    }

    public function waitProcess()
    {

    }

    public function upgrade()
    {
        $oilDistillerUpgrade = new PumpOilUpgradeAction();

        try {

            $oilDistillerUpgrade->upgrade($this->user_id);

        }
        catch (StateException $e) {

            \Session::flash('message', $e->getMessage());
        }


        return \Redirect::route('base_oilpump_page');
    }
}
