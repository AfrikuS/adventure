<?php

namespace App\Modules\Work\Domain\Commands\Order\Builder;

class GenerateMaterials
{
    public $order_id;
    public $count;

    public function __construct(int $order_id, int $count)
    {
        $this->order_id = $order_id;
        $this->count = $count;
    }
}
