<?php

namespace App\Transactions\Work;

use App\Factories\Work\WorkerFactory;
use App\Models\Hero\Resources;
use App\Models\Work\ShopInstrument;
use App\Models\Work\ShopMaterial;
use App\Models\Work\Worker;
use App\Repositories\HeroResourcesRepository;
use App\Repositories\Work\Team\WorkerRepository;
use Illuminate\Support\Facades\Session;

class ShopTransactions
{
    public static function transferShopMaterialToWorker(Worker $worker, ShopMaterial $shopMaterial)
    {
        $workerMaterial = $worker->getMaterialByCode($shopMaterial->code);
        
        $userResources = Resources::select('id', 'gold')->findOrFail($worker->id);

        \DB::transaction(function () use ($shopMaterial, $workerMaterial, $userResources) {

            $cost = $shopMaterial->price;

            $workerMaterial->increment('value', 70);

            $userResources->decrement('gold', $cost);
        });
    }

    // todo review / only first purchase
    public static function transferInstrumentToWorker($worker, ShopInstrument $instrument)
    {
        try {
            \DB::transaction(function () use ($worker, $instrument) {

                WorkerFactory::createWorkerInstrument($worker, $instrument->code);
                
                HeroResourcesRepository::subtractGoldFromUser($worker, $instrument->price);
            });
        }
        catch (\Exception $e) {
//            die($e->getMessage());
            Session::flash('message', $e->getMessage());

            redirect()->back();
        }
    }

    public static function transferShopMaterialToWorkerByCode(Worker $worker, $shopMaterial)
    {
        $workerMaterial = WorkerRepository::getMaterialByCode($worker, $shopMaterial->code);

        $userResources = Resources::select('id', 'gold')->find($worker->id);

        \DB::transaction(function () use ($shopMaterial, $workerMaterial, $userResources) {

            $cost = $shopMaterial->price;

            $workerMaterial->increment('value', 70);

            $userResources->decrement('gold', $cost);
        });
    }
}
