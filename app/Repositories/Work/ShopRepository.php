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
    
    public static function reindexPriceMaterials()
    {
        $materialsCodes = Material::select('id', 'code')->get();
        
        $materialsCodes->each(function ($item, $key) {
            PriceMaterial::updateOrCreate(
                ['code' => $item->code],
                ['price' => rand(3, 7),
                    'material_id' => $item->id,
                    'code' => $item->code,
                ]);
        });
    }

    public static function reindexInstrumentsPrices()
    {
        $instrumentCodes = Instrument::select('id', 'code')->get();
        
        $instrumentCodes->each(function ($item, $key) {
            ShopInstrument::updateOrCreate(
                ['code' => $item->code],
                ['price' => rand(583, 794),
                    'instrument_id' => $item->id,
                    'code' => $item->code,
                ]);
        });
    }

    /** @deprecated  todo review  @see transferInstrumentToUser */
    public static function addInstrumentToUser($worker, $instrument)
    {
        $userInstrument = WorkerInstrument::
            select('id', 'skill_level')
            ->firstOrCreate(['worker_id' => $worker->id, 'code' => $instrument->code]);
    }


}
