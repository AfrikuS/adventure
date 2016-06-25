<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Geo\Travel\MaterialPrice;
use App\Models\Geo\Travel\TempShop;
use App\Models\Work\WorkerMaterial;
use App\Repositories\Geo\TravelRepository;
use App\Repositories\Work\Team\WorkerRepository;
use App\Repositories\Work\WorkerMaterialsRepository;
use App\Transactions\Work\ShopTransactions;
use Illuminate\Support\Facades\Input;

class DockMarketController extends Controller
{
    public function index()
    {
//        GeoFactory::createTempShopWithMaterials(Carbon::create()->addHours(14));
        $travelShips = TravelRepository::getTravelShops();

        return $this->view('geo.market.dock_market', [
            'shops' => $travelShips,
        ]);
    }

    public function shipShop($id)
    {
        $shop = TempShop::find($id);
        $user_id = \Auth::id();

        $shopMaterials = MaterialPrice::where('shop_id', $shop->id)->get(['id', 'code', 'price']);

        $materialsCodes = $shopMaterials->map(function ($material, $key) {
            return $material->code;
        })->toArray();

        $userMaterials = WorkerMaterial::
                select('id', 'code', 'value')
                ->where('user_id', $user_id)
                ->whereIn('code', $materialsCodes)
                ->get();

        return $this->view('geo.market.ship_shop', [
            'shop' => $shop,
            'materials' => $shopMaterials,

            'pricesMaterials' => $shopMaterials,
            'userMaterials' => $userMaterials,
        ]);
    }

    public function buyMaterial()
    {
        $data = Input::all();
        $shop_id = $data['shop_id'];

        $materialCode = Input::get('material');
        $worker = WorkerRepository::findById(\Auth::id());

        $shopMaterial = MaterialPrice::where('shop_id', $shop_id)
            ->where('code', $materialCode)->get()->first();

//        ShopTransactions::transferShopMaterialToUser($worker, $shopMaterial);
        ShopTransactions::transferShopMaterialToWorkerByCode($worker, $shopMaterial); // todo review format-mess



//        $worker = WorkerRepository::findById(\Auth::id());

//        $shopMaterial = ShopRepository::getSingleShopMaterialByCode($materialCode);
        

        return \Redirect::back();
    }
}
