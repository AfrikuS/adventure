<?php

namespace App\Modules\Work\Persistence\Dao\Catalogs;

class MaterialsDao
{
    private $table = 'work_catalog_materials';
    
    public function getAll()
    {
        $materials = \DB::table($this->table)
            ->select(['id', 'code', 'title'])
            ->get();

        return $materials;
    }

    public function save($material)
    {
        if ($material->id != null) {

            \DB::table($this->table)
                ->where('id', $material->id)
                ->update([
                    'code'  => $material->code,
                    'title' => $material->title,
                ]);
        }
    }

}
