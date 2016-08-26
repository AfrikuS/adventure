<?php

namespace App\Modules\Work\Controllers\Shop;

use App\Exceptions\NotEnoughResourceException;
use App\Http\Requests;
use App\Models\Work\Worker\WorkerInstrument;
use App\Modules\Work\Commands\Shop\BuyInstrumentCommand;
use App\Modules\Work\Commands\Shop\BuyMaterialCommand;
use App\Modules\Work\Controllers\WorkController;
use App\Modules\Work\Domain\Services\Shop\ShopService;
use App\Modules\Work\Persistence\Repositories\Shop\ShopRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerRepo;
use App\Repositories\Work\Team\WorkerRepository;
use Illuminate\Support\Facades\Input;
use Session;

class ShopController extends WorkController
{
    public function index()
    {
        /** @var ShopRepo $shopRepo */
        $shopRepo = app('WorkShopRepo');
        $shopMaterials = $shopRepo->getMaterials();

        /** @var WorkerRepo $workerRepo */
        $workerRepo = app('WorkerRepo');
        $workerMaterials = $workerRepo->getMaterials($this->user_id);

        
        return $this->view('work.shop.shop_materials', [
            'userMaterials' => $workerMaterials,
            'shopMaterials' => $shopMaterials,
        ]);
    }

    public function instruments()
    {
        /** @var ShopRepo $shopRepo */
        $shopRepo = app('WorkShopRepo');
        $shopInstruments = $shopRepo->getInstruments();
        
        /** @var WorkerRepo $workerRepo */
        $workerRepo = app('WorkerRepo');
        $workerInstruments = $workerRepo->getInstruments($this->user_id);

        return $this->view('work.shop.shop_instruments', [
            'shopInstruments' => $shopInstruments,
            'userInstruments' => $workerInstruments,
        ]);
    }

    public function buyMaterial()
    {
        $materialCode = Input::get('material');

        $cmd = new BuyMaterialCommand();
        
        try {
        
            $cmd->buyMaterial($materialCode, $this->user_id);
        }
        
        catch (NotEnoughResourceException $e) 
        {
            Session::flash('message', 'Не хватает денег');
        }


        return \Redirect::route('work_shop_page');
    }

    public function buyInstrument()
    {
        $instrumentCode = Input::get('instrument');


        $cmd = new BuyInstrumentCommand();

        try {

            $cmd->buyInstrument($instrumentCode, $this->user_id);
        }
        
        catch (NotEnoughResourceException $e)
        {
            Session::flash('message', 'Не хватает денег');
        }
        
        return \Redirect::route('work_shop_instruments_page');
    }

    public function updateMaterialsPrices()
    {
        /** @var ShopService $shopService */
        $shopService = app('WorkShopService');

        $shopService->updateMaterialsPrices();

        return \Redirect::route('work_shop_page');
    }

    public function updateInstrumentsPrices()
    {
        /** @var ShopService $shopService */
        $shopService = app('WorkShopService');

        $shopService->updateInstrumentsPrices();

        return \Redirect::route('work_shop_instruments_page');
    }
}
