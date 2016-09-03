<?php

namespace App\Modules\Work\Commands\Admin\OrderBuilder;

use App\Modules\Work\Persistence\Repositories\Order\OrderMaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;

class ClearMaterialsAction
{
    
    public function clearMaterials($draft_id)
    {

        /** @var OrdersRepo $ordersRepo */
        $ordersRepo = app('OrdersRepo');
        
        /** @var OrderMaterialsRepo $materialsRepo */
        $materialsRepo = app('OrderMaterialsRepo');

//        $orderDraft = $ordersRepo->findOrderWithMaterialsById($draft_id);


//        $orderMaterialsCodes = $orderDraft->materials->getCodes();

 
         \DB::beginTransaction();
        try {

            $materialsRepo->deleteByOrder($draft_id);

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }
}
