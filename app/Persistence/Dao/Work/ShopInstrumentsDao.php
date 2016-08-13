<?php

namespace App\Persistence\Dao\Work;

class ShopInstrumentsDao
{
    private $table = 'work_shop_instruments';

    public function findByCode($code)
    {
        $instrument = \DB::table($this->table)
            ->select(['id', 'code', 'price'])
            ->where('code', $code)
            ->first();

        return $instrument;
    }

    /** @deprecated  */
    public function getAll()
    {
        $instruments = \DB::table($this->table)
            ->select(['id', 'code', 'price'])
            ->get();

        return $instruments;
    }
}
