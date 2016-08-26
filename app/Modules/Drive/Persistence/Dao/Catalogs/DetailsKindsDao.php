<?php

namespace App\Modules\Drive\Persistence\Dao\Catalogs;

class DetailsKindsDao
{
    private $table = 'drive_catalog_detail_kinds';

    public function create($kind)
    {
        $kind_id =
            \DB::table($this->table)->insertGetId([
                'title' => $kind,
            ]);

        return $kind_id;
    }

    public function get()
    {
        $kinds = 
            \DB::table($this->table)
                ->select(['id', 'title'])
                ->get();

        return $kinds;
    }
}
