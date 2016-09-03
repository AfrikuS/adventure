<?php

namespace App\Modules\Work\Commands\Admin\OrderBuilder;

use App\Modules\Work\Persistence\Repositories\Order\OrderMaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;

class SettingMaterialsValuesCommand
{
    public function fillMaterialValues($draft_id, array $materialsValues)
    {
        /** @var OrdersRepo $ordersRepo */
        $ordersRepo = app('OrdersRepo');

        /** @var OrderMaterialsRepo $orderMaterialsRepo */
        $orderMaterialsRepo = app('OrderMaterialsRepo');
        
        $orderDraft = $ordersRepo->findOrderWithMaterialsById($draft_id);
        
        \DB::beginTransaction();
        try {
            
            
            
            foreach ($materialsValues as $code => $value) {

                
                $material = $orderDraft->materials->getBy($code);

                $material->need = $value;
                
                $orderMaterialsRepo->updateNeedAmount($material);
                
//                $orderDraft->fillMaterialValueByCode($code, $value);
//
//                $material = $this->getMaterialByCode($code);
//                $material->update(['need' => $value]);

            }

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }
}
