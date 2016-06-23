<?php

namespace App\Http\Controllers\Work;

use App\Domain\Work\MaterialsActions;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Work\ShopInstrument;
use App\Models\Work\ShopMaterial;
use App\Models\Work\UserInstrument;
use App\Repositories\HeroResourcesRepository;
use App\Repositories\ShopRepository;
use App\Repositories\Work\OrderMaterialsRepository;
use App\Repositories\Work\Team\TeamWorkerRepository;
use App\Repositories\Work\UserMaterialsRepository;
use App\Transactions\Work\ShopTransactions;
use Illuminate\Support\Facades\Input;

class ShopController extends Controller
{
    public function index()
    {
        $shopMaterials = ShopMaterial::get(['code', 'price']);
        $userMaterials = UserMaterialsRepository::getMaterialsByUser(auth()->user());
        
        return $this->view('work/shop/shop_materials', [
            'pricesMaterials' => $shopMaterials,
            'userMaterials' => $userMaterials,
        ]);
    }

    public function instruments()
    {
        $shopInstruments = ShopInstrument::get();
        $userInstruments = UserInstrument::get();

        return $this->view('work/shop/shop_instruments', [
            'shopInstruments' => $shopInstruments,
            'userInstruments' => $userInstruments,
        ]);
    }

    public function buyMaterial()
    {
        $materialCode = Input::get('material');
        $worker = TeamWorkerRepository::findById(\Auth::id());

        $shopMaterial = ShopRepository::getSingleShopMaterialByCode($materialCode);

        ShopTransactions::transferShopMaterialToUser($worker, $shopMaterial);

        return \Redirect::route('work_shop_page');
    }

    public function buyInstrument()
    {
        $instrumentCode = Input::get('instrument');
        
        $instrument = ShopRepository::getSingleInstrumentByCode($instrumentCode);

        ShopTransactions::transferInstrumentToUser(auth()->user(), $instrument);

        return redirect()->back();
    }

    public function reindexPrices()
    {
        ShopRepository::reindexMaterialPrices();

        return redirect()->back();
    }

}
