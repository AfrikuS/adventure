<?php

namespace App\Modules\Work\Commands\Admin\OrderBuilder;

use App\Entities\Work\TeamOrderDraftEntity;
use App\Modules\Work\Domain\Entities\Order\Order;
use App\Modules\Work\Domain\Entities\Order\OrderDraft;
use App\Modules\Work\Domain\Services\Order\OrderBuilderService;
use App\Modules\Work\Persistence\Repositories\Order\OrderDraftsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;
use Finite\Exception\StateException;

class SettingOrderDataAction
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

    public function fillOrderData($draft_id, array $orderValues)
    {
        /** @var OrderDraft $order */
        $order = $this->draftsRepo->find($draft_id);

        $this->validateAction($order);


        $orderBuilderService = new OrderBuilderService();

        \DB::beginTransaction();
        try {


            $orderBuilderService->fillOrderData($order, $orderValues);


        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();

    }

    private function validateAction(OrderDraft $order)
    {
        if (! $order->isDraft()) {

            throw new StateException('Заказ должен быть на стадии черновика');
        }
    }
}
