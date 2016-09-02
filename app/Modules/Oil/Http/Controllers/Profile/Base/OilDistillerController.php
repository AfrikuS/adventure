<?php

namespace App\Modules\Oil\Http\Controllers\Profile\Base;

use App\Modules\Core\Http\Controller;
use App\Modules\Oil\Actions\Equipment\OilDistillerProcessAction;
use App\Modules\Oil\Actions\Equipment\OilDistillerUpgradeAction;
use App\Modules\Oil\Domain\Entities\OilDistiller;
use App\Modules\Oil\Persistence\Repositories\OilDistillerRepo;
use Finite\Exception\StateException;

class OilDistillerController extends Controller
{
    public function index()
    {
        /** @var OilDistillerRepo $oilDistillerRepo */
        $oilDistillerRepo = app('OilDistillerRepo');

        /** @var OilDistiller $oilDistiller */
        $oilDistiller = $oilDistillerRepo->findBy($this->user_id);


        return $this->view('oil.profile.base.oil_distiller', [
            'distiller' => $oilDistiller,
        ]);
    }

    public function process()
    {
        $oilDistillerProcess = new OilDistillerProcessAction();

        $oilDistillerProcess->process($this->user_id);


        return \Redirect::route('base_oil_distiller_page');
    }

    public function waitProcess()
    {

    }

    public function upgrade()
    {
        $oilDistillerUpgrade = new OilDistillerUpgradeAction();

        try {

            $oilDistillerUpgrade->upgrade($this->user_id);

        }
        catch (StateException $e) {

            \Session::flash('message', $e->getMessage());
        }


        return \Redirect::route('base_oil_distiller_page');
    }
}
