<?php

namespace App\Persistence\Repositories\Work;

use App\Persistence\Dao\Work\OrderMaterialsDao;
use App\Persistence\Models\Work\Order\OrderMaterial;

class OrderMaterialsRepo
{
    /** @var OrderMaterialsDao */
    private $materialsDao;

    public function __construct()
    {
        $this->materialsDao = new OrderMaterialsDao();
    }

/*    public function getCodes()
    {
//        $materialsCodes = Material::get(['id', 'code'])->pluck('code');
        
        $codes = $this->materialsDao->getCodes();
        
        $codesArr = array_map(function ($codeObj) {
            return $codeObj->code;
        }, $codes);

        return $codesArr;
    }*/

    public function createOrderMaterial($order_id, $code, $need)
    {
        $material = new \stdClass();
        $material->order_id = $order_id;
        $material->code = $code;
        $material->need = $need;
        $material->stock = 0;

        $this->materialsDao->create($material);
    }

    public function getCodesByOrderId($order_id)
    {
        $materials = $this->materialsDao->getAllByOrderId($order_id);

        $codesArr = array_map(function ($material) {
            return $material->code;
        }, $materials);

        return $codesArr;
    }

    public function findBy($order_id, $code)
    {
        $materialData = $this->materialsDao->find($order_id, $code);

        if (null == $materialData) {
            return null;
        }

        return new OrderMaterial($materialData);
    }

    public function update($material)
    {
        $this->materialsDao->update($material);
    }

    public function deleteByOrder($order_id)
    {
        $this->materialsDao->deleteByOrder($order_id);
    }
}
