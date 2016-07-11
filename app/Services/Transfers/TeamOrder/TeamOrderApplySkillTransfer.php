<?php

namespace App\Services\Transfers\TeamOrder;

use App\Models\Work\Worker;
use App\Services\Transfers\ITransfer;
use App\Entities\Work\TeamOrderEntity;

class TeamOrderApplySkillTransfer implements ITransfer
{
    /** @var  TeamOrderEntity */
    private $order;
    /** @var  string */
    private $skillCode;
    /** @var  Worker */
    private $worker;
    /** @var  integer */
    private $amount;

    /**
     * OrderMaterialTransfer constructor.
     * @param $materialCode
     * @param $order
     * @param $worker
     */
    public function __construct($order, $worker, $skillCode, $amount)
    {
        $this->skillCode = $skillCode;
        $this->order = $order;
        $this->worker = $worker;
        $this->amount = $amount;
    }

    public function execute()
    {
        $orderSkill = $this->order->getSkillByCode($this->skillCode);

        $orderSkill->increment('stock_times', $this->amount);
    }
}
