<?php

namespace App\Modules\Profile\Controllers;

use App\Commands\Hero\ResourceStore\OilStoreUpgradeCmd;
use App\Commands\Hero\ResourceStore\PetrolStoreUpgradeCmd;
use App\Commands\Hero\ResourceStore\WaterStoreUpgradeCmd;
use App\Http\Controllers\Controller;
use App\Repositories\Core\Equipment\OilPumpRepo;
use App\Repositories\Core\ResourceStore\OilStoreRepo;
use App\Repositories\Core\ResourceStore\PetrolStoreRepo;
use App\Repositories\Core\ResourceStore\WaterStoreRepo;

class ResourceStoreController extends Controller
{
    /** @var OilStoreRepo */
    protected $oilStoreRepo;

    /** @var PetrolStoreRepo */
    protected $petrolStoreRepo;

    /** @var WaterStoreRepo */
    protected $waterStoreRepo;

    
    /** @var OilPumpRepo */
    protected $pumpOilRepo;

    public function __construct()
    {
        parent::__construct();
        
        $this->oilStoreRepo = new OilStoreRepo();
        $this->petrolStoreRepo = new PetrolStoreRepo();
        $this->waterStoreRepo = new WaterStoreRepo();
        $this->pumpOilRepo = new OilPumpRepo();
    }

    public function index()
    {
        $oilStore = $this->oilStoreRepo->getOilStoreDto($this->user_id);
        
        $oilStoreNext = $this->oilStoreRepo->getOilStoreNextDto($oilStore->level);


        $petrolStore = $this->petrolStoreRepo->getPetrolStoreDto($this->user_id);

        $petrolStoreNext = $this->petrolStoreRepo->getPetrolStoreNextDto($petrolStore->level);

        
        $waterStore = $this->waterStoreRepo->getWaterStoreDto($this->user_id);

        $waterStoreNext = $this->waterStoreRepo->getWaterStoreNextDto($waterStore->level);



        $pumpOil = $this->pumpOilRepo->getPumpOilDto($this->user_id);
        
        $oilDistillator = $this->pumpOilRepo->getOilDistillatorDto($this->user_id);


        return $this->view('profile.store.index', [
            'oilStore'     => $oilStore,
            'oilStoreNext' => $oilStoreNext,

            'petrolStore'     => $petrolStore,
            'petrolStoreNext' => $petrolStoreNext,

            'waterStore'     => $waterStore,
            'waterStoreNext' => $waterStoreNext,
            
            'pumpOil' => $pumpOil,
            'oilDistillator' => $oilDistillator,
        ]);
    }

    public function upgradeOilStore()
    {
        $oilStoreUpgrader = new OilStoreUpgradeCmd($this->oilStoreRepo);
        
        try {

            $oilStoreUpgrader->upgrade($this->user_id);

        } 
        catch (\Exception $e) {
            \Session::flash('msg', 'Oil store max level');
        }
        
        
        return \Redirect::route('profile_resource_stores_page');
    }

    public function upgradePetrolStore()
    {
        $petrolStoreUpgrader = new PetrolStoreUpgradeCmd($this->petrolStoreRepo);

        try {

            $petrolStoreUpgrader->upgradeLevel($this->user_id);

        }
        catch (\Exception $e) {
            \Session::flash('msg', 'Petrol store max level');
        }


        return \Redirect::route('profile_resource_stores_page');
    }

    public function upgradeWaterStore()
    {
        $waterStoreUpgrader = new WaterStoreUpgradeCmd($this->waterStoreRepo);

        try {

            $waterStoreUpgrader->upgrade($this->user_id);

        }
        catch (\Exception $e) {
            \Session::flash('msg', 'Water store max level');
        }


        return \Redirect::route('profile_resource_stores_page');
    }
}
