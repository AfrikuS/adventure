<?php

namespace App\Modules\Geo\Http\Controllers\Business;

use App\Modules\Core\Http\Controller;
use App\Models\Geo\Trader\TempoShop;
use App\Repositories\Generate\EntityGenerator;
use Carbon\Carbon;

class TempoShopController extends Controller
{
    public function index()
    {
        $shops = TempoShop::
            where('owner_id', \Auth::id())
            ->select('id', 'owner_id', 'status')
            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), geo_trader_temporary_shops.date_ending) AS duration_seconds')
            ->havingRaw('duration_seconds > 0')

            ->get();

        return $this->view('geo.business.tempo_shops', [
//            'voyages' => $voyages,
            'shops' => $shops,
//            'locationsSelect'  => $locationsSelect,
        ]);
    }

    public function addTempoShop()
    {
        $trader_id = \Auth::id();
        $endingTime = Carbon::create()->addHour(25)->toDateTimeString();

        TempoShop::create([
            'owner_id' => $trader_id,
            'date_ending' => $endingTime,
            'status' => 'active',
        ]);

        return \Redirect::route('geo_trader_temposhops_page');
    }

    public function show($id)
    {
        $shop = TempoShop::find($id);
    }
}
