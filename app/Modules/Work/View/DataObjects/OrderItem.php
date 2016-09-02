<?php

namespace App\Modules\Work\View\DataObjects;

class OrderItem
{
    public $id;
    public $price;
    public $domainTitle;
    public $status;

    public function __construct(\stdClass $orderItemData)
    {
        $this->id = $orderItemData->id;
        $this->price = $orderItemData->price;
        $this->domainTitle = $orderItemData->domain_title;
        $this->status = $orderItemData->status;
    }
}
