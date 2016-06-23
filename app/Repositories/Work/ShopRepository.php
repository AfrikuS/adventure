<?php

namespace App\Repositories;

use App\Models\Work\WorkMaterial;
use App\Models\Work\ShopInstrument;
use App\Models\Work\ShopMaterial;
use App\Models\Work\UserInstrument;
use App\Models\Work\WorkInstrument;

class ShopRepository
{
    public static function getSingleShopMaterialByCode(string $materialCode)
    {
        $material = ShopMaterial::select('id', 'code', 'price')->whereCode($materialCode)->firstOrFail();

        return $material;
    }
    
    public static function getSingleMaterialByCode(string $materialCode)
    {
        $material = WorkMaterial::select('id', 'code', 'title')->whereCode($materialCode)->firstOrFail();

        return $material;
    }
    
    public static function reindexMaterialPrices()
    {
        $materialsCodes = WorkMaterial::select('id', 'code')->get();
        
        $materialsCodes->each(function ($item, $key) {
            ShopMaterial::updateOrCreate(
                ['code' => $item->code],
                ['price' => rand(3, 7),
                    'material_id' => $item->id,
                    'code' => $item->code,
                ]);
        });
    }

    public static function reindexInstrumentsPrices()
    {
        $instrumentCodes = WorkInstrument::select('id', 'code')->get();
        
        $instrumentCodes->each(function ($item, $key) {
            ShopInstrument::updateOrCreate(
                ['code' => $item->code],
                ['price' => rand(583, 794),
                    'instrument_id' => $item->id,
                    'code' => $item->code,
                ]);
        });
    }

    public static function getSingleInstrumentByCode($instrumentCode): ShopInstrument
    {
        $instrument = ShopInstrument::select('id', 'code', 'price')->whereCode($instrumentCode)->firstOrFail();
        return $instrument;
    }

    /** @deprecated  todo review  @see transferInstrumentToUser */
    public static function addInstrumentToUser($worker, $instrument)
    {
        $userInstrument = UserInstrument::
            select('id', 'skill_level')
            ->firstOrCreate(['worker_id' => $worker->id, 'code' => $instrument->code]);
    }


}
