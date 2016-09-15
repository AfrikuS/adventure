<?php

namespace App\Modules\Work\Persistence\Repositories\Order;

use App\Modules\Work\Domain\Entities\Order\Order;
use App\Modules\Work\Domain\Entities\Order\OrderDraft;
use App\Modules\Work\Persistence\Dao\Order\OrdersDao;

class OrderDraftsRepo
{
    /** @var OrdersDao */
    private $ordersDao;

    /** @var OrderMaterialsRepo */
    private $materialsRepo;

    /** @var OrderSkillsRepo */
    private $skillsRepo;

    public function __construct(OrdersDao $ordersDao,
                                OrderMaterialsRepo $materialsRepo,
                                OrderSkillsRepo $skillsRepo
    )
    {
        $this->materialsRepo = $materialsRepo;
        $this->ordersDao = $ordersDao;
        $this->skillsRepo = $skillsRepo;
    }

    public function create($desc, $domain_id, $price, $customer_id)
    {
        return
            $this->ordersDao->create(
                $desc,
                $domain_id,
                $price,
                $customer_id,

                OrderDraft::STATUS_DRAFT,
                Order::TYPE_INDIVIDUAL
            );
    }

    public function get()
    {
        $draftsData = $this->ordersDao->getDrafts();
        
        return $draftsData;
    }

    public function find($id)
    {
        $draftData = $this->ordersDao->find($id);
        
        return new OrderDraft($draftData);
    }

    public function updateData(OrderDraft $draft)
    {
        $this->ordersDao->updateData(
            $draft->id,
            $draft->desc,
            $draft->price
        );
    }

    public function updateStatus(OrderDraft $orderDraft)
    {
        $this->ordersDao->update(
            $orderDraft->id,
            $orderDraft->status,
            null
        );
    }
}
