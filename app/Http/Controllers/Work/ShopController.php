<?php

namespace App\Http\Controllers\Work;

use App\Commands\Shop\BuyInstrumentCommand;
use App\Commands\Shop\BuyMaterialCommand;
use App\Exceptions\NotEnoughResourceException;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Work\PriceMaterial;
use App\Models\Work\ShopInstrument;
use App\Models\Work\Worker\WorkerInstrument;
use App\Persistence\Repositories\HeroRepo;
use App\Persistence\Repositories\Work\ShopRepo;
use App\Repositories\HeroRepositoryObj;
use App\Repositories\Work\ShopRepository;
use App\Repositories\Work\Team\WorkerRepository;
use App\Repositories\Work\WorkerRepositoryObj;
use App\ViewData\Work\ShopValueObject;
use Illuminate\Support\Facades\Input;
use Session;

class ShopController extends WorkController
{
    public function index()
    {
        $shopMaterials = PriceMaterial::get(['code', 'price']);
        
        $worker = WorkerRepository::findWithMaterialsAndSkillsById(\Auth::id());
        $userMaterials = $worker->materials;
        
        $shop = new ShopValueObject($shopMaterials);
        
        return $this->view('work.shop.shop_materials', [
//            'pricesMaterials' => $shopMaterials,
            'userMaterials' => $userMaterials,
            'shop' => $shop,
        ]);
    }

    public function instruments()
    {
        $shopInstruments = ShopInstrument::get();
        $userInstruments = WorkerInstrument::get();

        return $this->view('work.shop.shop_instruments', [
            'shopInstruments' => $shopInstruments,
            'userInstruments' => $userInstruments,
        ]);
    }

    public function buyMaterial(HeroRepo $heroRepo, ShopRepo $shopRepo)
    {
        $materialCode = Input::get('material');

        $cmd = new BuyMaterialCommand($heroRepo, $shopRepo);
        
        try {
        
            $cmd->buyMaterial($materialCode, $this->worker->id);
        }
        
        catch (NotEnoughResourceException $e) 
        {
            Session::flash('message', 'Не хватает денег');
        }


        return \Redirect::route('work_shop_page');
    }

    public function buyInstrument(WorkerRepositoryObj $workerRepo, ShopRepo $shopRepo, HeroRepo $heroRepo)
    {
        $instrumentCode = Input::get('instrument');


        $cmd = new BuyInstrumentCommand(
            $workerRepo,
            $shopRepo,
            $heroRepo
        );

        try {

            $cmd->buyInstrument($instrumentCode, $this->worker->id);
        }
        
        catch (NotEnoughResourceException $e)
        {
            Session::flash('message', 'Не хватает денег');
        }
        
        return \Redirect::route('work_shop_instruments_page');
    }

    public function reindexPrices()
    {
        ShopRepository::reindexMaterialPrices();

        return \Redirect::route('work_shop_page');
    }

}
