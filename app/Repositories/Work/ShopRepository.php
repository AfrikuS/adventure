<?php

namespace App\Repositories\Work;

use App\Models\Work\Catalogs\Instrument;
use App\Models\Work\Catalogs\Material;
use App\Models\Work\PriceMaterial;
use App\Models\Work\ShopInstrument;
use App\Models\Work\Worker\WorkerInstrument;

class ShopRepository
{
    public static function getSingleShopMaterialByCode(string $materialCode)
    {
        $material = PriceMaterial::select('id', 'code', 'price')->whereCode($materialCode)->first();

        return $material;
    }

    public static function getMaterialPriceByCode(string $materialCode): int
    {
        $materialPrice = ShopRepository::getSingleShopMaterialByCode($materialCode);

        if ($materialPrice === null) {
            throw new \Exception;
        }

        return $materialPrice->price;
    }

    public static function getInstrumentPriceByCode($instrumentCode): int
    {
        $instrumentPrice = ShopInstrument::select('id', 'code', 'price')->whereCode($instrumentCode)->first();

        if ($instrumentPrice === null) {
            throw new \Exception;
        }

        return $instrumentPrice->price;
    }
    

    /** @deprecated  todo review  @see transferInstrumentToUser */
    public static function addInstrumentToUser($worker, $instrument)
    {
        $userInstrument = WorkerInstrument::
            select('id', 'skill_level')
            ->firstOrCreate(['worker_id' => $worker->id, 'code' => $instrument->code]);
    }


}
