<?php

namespace App\Modules\Geo\Http\Controllers;

use App\Commands\Shop\BuyMaterialCommand;
use App\Modules\Core\Http\Controller;
use App\Http\Requests;
use App\Models\Geo\Travel\MaterialPrice;
use App\Models\Geo\Travel\TempShop;
use App\Models\Work\Worker\WorkerMaterial;
use App\Repositories\Geo\TravelRepository;
use App\Repositories\HeroRepositoryObj;
use App\Repositories\ShopRepository;
use App\Repositories\Work\WorkerRepositoryObj;
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
//        $data = Input::all();
        $materialCode = Input::get('material');
//        $shop_id = $data['shop_id'];
        $user_id = \Auth::id();


        $cmd = new BuyMaterialCommand(new WorkerRepositoryObj, new ShopRepository, new HeroRepositoryObj);
        
        $cmd->buyMaterial($materialCode, $user_id);

        return \Redirect::back();
    }
}
