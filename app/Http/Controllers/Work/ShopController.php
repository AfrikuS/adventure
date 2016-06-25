<?php

namespace App\Http\Controllers\Work;

use App\Domain\Work\MaterialsActions;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Work\ShopInstrument;
use App\Models\Work\ShopMaterial;
use App\Models\Work\Worker\UserInstrument;
use App\Models\Work\Worker\WorkerInstrument;
use App\Repositories\HeroResourcesRepository;
use App\Repositories\ShopRepository;
use App\Repositories\Work\OrderMaterialsRepository;
use App\Repositories\Work\Team\WorkerRepository;
use App\Repositories\Work\WorkerMaterialsRepository;
use App\Transactions\Work\ShopTransactions;
use Illuminate\Support\Facades\Input;

class ShopController extends Controller
{
    public function index()
    {
        $shopMaterials = ShopMaterial::get(['code', 'price']);
        
        $worker = WorkerRepository::findWithMaterialsAndSkillsById(\Auth::id());
        $userMaterials = $worker->materials;
        
        return $this->view('work/shop/shop_materials', [
            'pricesMaterials' => $shopMaterials,
            'userMaterials' => $userMaterials,
        ]);
    }

    public function instruments()
    {
        $shopInstruments = ShopInstrument::get();
        $userInstruments = WorkerInstrument::get();

        return $this->view('work/shop/shop_instruments', [
            'shopInstruments' => $shopInstruments,
            'userInstruments' => $userInstruments,
        ]);
    }

    public function buyMaterial()
    {
        $materialCode = Input::get('material');
        $worker = WorkerRepository::findWithMaterialsAndSkillsById(\Auth::id());

        $shopMaterial = ShopRepository::getSingleShopMaterialByCode($materialCode);

        ShopTransactions::transferShopMaterialToWorker($worker, $shopMaterial);

        return \Redirect::route('work_shop_page');
    }

    public function buyInstrument()
    {
        $instrumentCode = Input::get('instrument');
        $worker = WorkerRepository::findWithMaterialsAndSkillsById(\Auth::id());
        
        $instrument = ShopRepository::getSingleInstrumentByCode($instrumentCode);

        ShopTransactions::transferInstrumentToWorker($worker, $instrument);

        return redirect()->back();
    }

    public function reindexPrices()
    {
        ShopRepository::reindexMaterialPrices();

        return redirect()->back();
    }

}
