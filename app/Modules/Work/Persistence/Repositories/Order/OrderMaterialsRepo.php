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
        $materials = EntityStore::get(OrderMaterialsCollection::class, 'order:'.$order_id);

        if ($materials != null) {
            return $materials;
        }

        $materialsData = $this->materialsDao->getByOrder($order_id);

        $materials = new OrderMaterialsCollection();

        foreach ($materialsData as $materialData) {

            $material = new OrderMaterial($materialData);

            $materials->add($material);
        }

        EntityStore::add($materials, 'order:'.$order_id);

        return $materials;
    }

    public function findBy($order_id, $code)
    {
        $materialData = $this->materialsDao->findBy($order_id, $code);

        if (null == $materialData) {
            return null;
        }

        return new OrderMaterial($materialData);
    }

    public function updateStockAmount(OrderMaterial $material)
    {
        $this->materialsDao->update(
            $material->id, 
            $material->stock
        );
    }
    
    public function deleteByOrder($order_id)
    {
        $this->materialsDao->deleteByOrder($order_id);
    }

    /** @deprecated  */
    public function deleteSome(array $excessMaterials)
    {
        $ids = array_map(function (OrderMaterial $material) {
            
            return $material->id;
        }, $excessMaterials);
        
        $this->materialsDao->deleteByIds($ids);
    }

    public function updateNeedAmount(OrderMaterial $material)
    {
        $this->materialsDao->updateNeed(
            $material->id,
            $material->need
        );
    }
}
