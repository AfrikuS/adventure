<?php

namespace App\Modules\Work\Commands\Admin\OrderBuilder;

use App\Modules\Work\Domain\Entities\Order\OrderDraft;
use App\Modules\Work\Domain\Services\Order\OrderBuilderService;
use App\Modules\Work\Persistence\Repositories\Order\OrderDraftsRepo;
use Finite\Exception\StateException;

class PublishOrderAction
{
    /** @var OrderDraftsRepo */
    private $draftsRepo;

    public function __construct()
    {
        $this->draftsRepo = app('OrderDraftsRepo');
    }
    
    public function publish($draft_id)
    {
        $orderDraft = $this->draftsRepo->find($draft_id);

        $this->validateAction($orderDraft);
        
        
        
        $orderBuilderService = new OrderBuilderService();

        $orderBuilderService ->publishOrder($orderDraft);
        
    }

    private function validateAction(OrderDraft $orderDraft)
    {
        if (! $orderDraft->isDraft()) {

            throw new StateException('Заказ должен быть на стадии заготовки');
        }
    }
}
