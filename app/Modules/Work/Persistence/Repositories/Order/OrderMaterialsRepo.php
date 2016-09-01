<?php

namespace App\Modules\Work\Persistence\Repositories\Order;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Work\Domain\Entities\Order\OrderMaterial;
use App\Modules\Work\Domain\Entities\Order\OrderMaterialsCollection;
use App\Modules\Work\Persistence\Dao\Order\OrderMaterialsDao;

class OrderMaterialsRepo
{
    /** @var OrderMaterialsDao */
    private $materialsDao;

    public function __construct(OrderMaterialsDao $materialsDao)
    {
        $this->materialsDao = $materialsDao;
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

    public function createOrderMaterial($order_id, $code, $need, $stock = 0)
    {
        return
            $this->materialsDao->create(
                $order_id,
                $code,
                $need,
                $stock
            );
    }

    public function getMaterialsCollection($order_id)
    {
        $materials = EntityStore::get(OrderMaterialsCollection::class, 'order'.$order_id);

        if ($materials != null) {
            return $materials;
        }

        $materialsData = $this->materialsDao->getByOrder($order_id);

        $materials = new OrderMaterialsCollection();

        foreach ($materialsData as $materialData) {

            $material = new OrderMaterial($materialData);

            $materials->addMaterial($material);
        }

        EntityStore::add($materials, 'order'.$order_id);

        return $materials;

    }

    public function getCodesByOrderId($order_id)
    {
        $materials = $this->materialsDao->getByOrder($order_id);

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
