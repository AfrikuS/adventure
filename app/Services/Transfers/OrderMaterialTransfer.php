<?php

namespace App\Services\Transfers;

use App\Models\Work\Worker;
use App\StateMachines\Work\OrderStateMachine;

class OrderMaterialTransfer implements ITransfer
{
    /** @var  OrderStateMachine */
    private $order;
    /** @var  string */
    private $materialCode;
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
    public function __construct($order, $worker, $materialCode, $amount)
    {
        $this->materialCode = $materialCode;
        $this->order = $order;
        $this->worker = $worker;
        $this->amount = $amount;
    }

    public function execute()
    {
        $orderMaterial = $this->order->getMaterialByCode($this->materialCode);
        $workerMaterial = $this->worker->getMaterialByCode($this->materialCode);

        $orderMaterial->stock += $this->amount;
        $orderMaterial->save();

        $workerMaterial->value -= $this->amount;
        $workerMaterial->save();
    }
}
