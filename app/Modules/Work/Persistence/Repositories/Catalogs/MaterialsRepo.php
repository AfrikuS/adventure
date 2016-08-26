<?php

namespace App\Modules\Work\Persistence\Repositories\Catalogs;

use App\Modules\Work\Persistence\Dao\Catalogs\MaterialsDao;

class MaterialsRepo
{
    /** @var MaterialsDao */
    private $materialsDao;

    public function __construct(MaterialsDao $materialsDao)
    {
        $this->materialsDao = $materialsDao;
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
