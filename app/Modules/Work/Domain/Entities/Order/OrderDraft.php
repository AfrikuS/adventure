<?php

namespace App\Modules\Work\Domain\Entities\Order;

class OrderDraft extends Order
{
    const STATUS_DRAFT = 'draft';
    
    public function publish()
    {
        $this->status = self::STATUS_FREE;
    }

    public function isDraft()
    {
        return $this->status === self::STATUS_DRAFT;
    }
}
