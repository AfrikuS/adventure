<?php

namespace App\Persistence\Repositories\Work\Catalogs;

use App\Persistence\Dao\Work\Catalogs\MaterialsDao;

class MaterialsRepo
{
    /** @var MaterialsDao */
    private $materialsDao;

    public function __construct()
    {
        $this->materialsDao = new MaterialsDao();
    }

    public function getCodes()
    {
//        $materialsCodes = Material::get(['id', 'code'])->pluck('code');
        
        $materials = $this->materialsDao->getAll();
        
        $codesArr = array_map(function ($material) {
            return $material->code;
        }, $materials);

        return $codesArr;
    }


    public function save($material)
    {
        $this->materialsDao->save($material);
    }

}
