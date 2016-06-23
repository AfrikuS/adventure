<?php

namespace App\Transactions\Work;

use App\Domain\Work\MaterialsActions;
use App\Models\HeroResources;
use App\Models\Work\ShopInstrument;
use App\Models\Work\ShopMaterial;
use App\Models\Work\UserInstrument;
use App\Models\Work\UserMaterial;
use App\Repositories\HeroResourcesRepository;
use App\Repositories\ShopRepository;
use App\Repositories\Work\Team\TeamWorkerRepository;
use Illuminate\Support\Facades\Session;

class ShopTransactions
{
    public static function transferShopMaterialToUser($worker, ShopMaterial $shopMaterial)
    {
        $workerMaterial = TeamWorkerRepository::getMaterialByCode($worker, $shopMaterial->code);
        
        $userResources = HeroResources::select('id', 'gold')->findOrFail($worker->id);

        \DB::transaction(function () use ($shopMaterial, $workerMaterial, $userResources) {

            $cost = $shopMaterial->price;

            $workerMaterial->increment('value', 10);

            $userResources->decrement('gold', $cost);
        });
    }

    // todo review / only first purchase
    public static function transferInstrumentToUser($user, ShopInstrument $instrument)
    {
        $userResources = HeroResources::findOrFail($user->id, ['id', 'gold']);

        try {
            \DB::transaction(function () use ($user, $instrument, $userResources) {


                UserInstrument::create([
                    'worker_id' => $user->id,
                    'code' => $instrument->code,
                    'skill_level' => 0,
                ]);

                $instrumentPrice = $instrument->price;

                $userResources->decrement('gold', $instrumentPrice);
            });
        }
        catch (\Exception $e) {
//            die($e->getMessage());
            Session::flash('message', $e->getMessage());

            redirect()->back();
        }
    }
}
