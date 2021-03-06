<?php

namespace App\Modules\Work\Commands\Admin\OrderBuilder;

use App\Modules\Work\Domain\Entities\Order\OrderDraft;
use App\Modules\Work\Domain\Services\Order\OrderBuilderService;
use App\Modules\Work\Persistence\Repositories\Order\OrderDraftsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;

class ReCheckMaterialsCommand
{
    /** @var OrderDraftsRepo */
    private $draftsRepo;
    
    /** @var OrdersRepo */
    private $orders;

    public function __construct()
    {
        $this->draftsRepo = app('OrderDraftsRepo');
        $this->orders = app('OrdersRepo');
    }
    
    public function reCheckMaterials($draft_id, $checkedCodes)
    {
        /** @var OrderDraft $order */
        $order = $this->orders->findOrderWithMaterialsById($draft_id);
        
        
        $orderBuilderService = new OrderBuilderService();

        
        \DB::beginTransaction();
        try {


            if ($order->materials->isDiffsByCodes($checkedCodes)) {
                
                
                $orderBuilderService->clearMaterials($draft_id);

                $orderBuilderService->createMaterialsByCodes($draft_id, $checkedCodes);
            }

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }
}
