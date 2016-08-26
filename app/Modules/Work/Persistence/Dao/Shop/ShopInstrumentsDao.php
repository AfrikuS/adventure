<?php

namespace App\Modules\Work\Persistence\Dao\Shop;

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

//    /** @deprecated  */
    public function getAll()
    {
        $instruments = \DB::table($this->table)
            ->select(['id', 'code', 'price'])
            ->get();

        return $instruments;
    }

    public function updatePrice($id, $price)
    {
        \DB::table($this->table)
            ->where('id', $id)
            ->update([
                'price' => $price,
            ]);
    }
}
