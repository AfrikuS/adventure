<?php

namespace App\Persistence\Models\Work\Order;

class StockDataDto
{
    public $needSum;
    public $stockSum;

    public function __construct(int $needSum, int $stockSum)
    {
        $this->needSum = $needSum;
        $this->stockSum = $stockSum;
    }

    public function isStockCompleted()
    {
        return $this->needSum == $this->stockSum;
    }
}
