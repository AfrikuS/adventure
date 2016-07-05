<?php

namespace App\Services\Transfers;

use App\Models\Core\Hero;

class HeroesGoldTransfer implements ITransfer
{
    /** @var  Hero */
    private $from;
    /** @var  Hero */
    private $to;
    /** @var  integer */
    private $amount;

    /**
     * HeroesGoldTransfer constructor.
     * @param int $amount
     * @param Hero $from
     * @param Hero $to
     */
    public function __construct(Hero $from, Hero $to, $amount)
    {
        $this->from = $from;
        $this->to = $to;
        $this->amount = $amount;
    }
    
    public function execute()
    {
        $this->from->decrement('gold', $this->amount);
        $this->to->increment('gold', $this->amount);
    }
}
