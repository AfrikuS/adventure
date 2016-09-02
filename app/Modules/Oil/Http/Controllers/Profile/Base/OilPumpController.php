<?php

namespace App\Modules\Oil\Http\Controllers\Profile\Base;

use App\Http\Controllers\Controller;
use App\Modules\Oil\Actions\Equipment\OilPumpProcessAction;
use App\Modules\Oil\Actions\Equipment\PumpOilUpgradeAction;
use App\Modules\Oil\Domain\Entities\OilPump;
use App\Modules\Oil\Persistence\Repositories\OilPumpRepo;
use Finite\Exception\StateException;

class OilPumpController extends Controller
{
    public function index()
    {
        /** @var OilPumpRepo $oilPumpRepo */
        $oilPumpRepo = app('OilPumpRepo');

        /** @var OilPump $oilPump */
        $oilPump = $oilPumpRepo->findBy($this->user_id);


        return $this->view('oil.profile.base.oil_pump', [
            'oilPump' => $oilPump,
        ]);
    }

    public function process()
    {
        $oilPumpProcess = new OilPumpProcessAction();

        $oilPumpProcess->process($this->user_id);

        
        return \Redirect::route('base_oilpump_page');
    }

    public function waitProcess()
    {

    }

    public function upgrade()
    {
        $oilPumpUpgrade = new PumpOilUpgradeAction();

        try {

            $oilPumpUpgrade->upgrade($this->user_id);

        }
        catch (StateException $e) {

            \Session::flash('message', $e->getMessage());
        }

        
        return \Redirect::route('base_oilpump_page');
    }
}
