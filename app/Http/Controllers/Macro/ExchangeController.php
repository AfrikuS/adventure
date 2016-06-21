<?php

namespace App\Http\Controllers\Macro;

use App\Domain\PlayersOperations;
use App\Http\Controllers\MacroController;
use App\Http\Requests\Process\ExchangeChangeRequest;
use App\Http\Requests\Process\ExchangeOfferRequest;
use App\Models\Macro\ExchangeGood;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ExchangeController extends MacroController
{
    public function index()
    {
//        $building = Building::find($building_id);
        $goods = ExchangeGood::get();

        return $this->view('macro/exchange', [
            'goods' => $goods,
        ]);
    }

    public function change(ExchangeChangeRequest $request)
    {
        $data = $request->all();
        $good = ExchangeGood::find($data['good_id']);

        $offerUser = User::find($good->user_id);
        $changerUser = auth()->user();

        PlayersOperations::exchangeResources($good, $changerUser, $offerUser);

        return redirect('/macro/exchange');
    }

    public function offer(ExchangeOfferRequest $request)
    {
        $data = $request->all();

        $good = new ExchangeGood();
        $good->resource_title = $data['resource_title'];
        $good->resource_count = $data['resource_count'];
        $good->intent_resource_title = $data['intent_resource_title'];
        $good->intent_resource_count = $data['intent_resource_count'];
        $good->user_id = auth()->user()->id;
        $good->save();

        return redirect('/macro/exchange');
    }
}
