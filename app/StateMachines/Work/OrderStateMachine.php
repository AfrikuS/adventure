<?php

namespace App\StateMachines\Work;

use App\Models\Work\Order;
use App\StateMachines\StateMachineTrait;
use App\Transactions\Work\OrderTransactions;
use Finite\Loader\ArrayLoader;
use Finite\StatefulInterface;
use Finite\StateMachine\StateMachine;

class OrderStateMachine implements StatefulInterface
{
    use StateMachineTrait;

    /** @var $order Order */
    private $order;

    private $loader;

    public $state;
    /** @var StateMachine */
    public $stateMachine;

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->state = $order->status;
        
        $this->initStatesTransitions();
    }

    public function getSM()
    {
        return $this->stateMachine;
    }

    private function initStatesTransitions()
    {
        $this->stateMachine = new StateMachine;
        $this->loader       = new ArrayLoader([
            'class'  => Order::class,  // self ?
            'states' => [
                'free'            => ['type' => 'initial', 'properties' => []],
                'stock_materials' => ['type' => 'normal',  'properties' => []],
                'stock_skills'    => ['type' => 'normal',  'properties' => []],
                'completed'       => ['type' => 'final',   'properties' => []],
            ],
            'transitions' => [
                'accept'  =>                ['from' => ['free'],            'to' => 'stock_materials'],
                'finish_stock_materials' => ['from' => ['stock_materials'], 'to' => 'stock_skills'],
                'finish_stock_skills'  =>   ['from' => ['stock_skills'],    'to' => 'completed'],
            ]
        ]);

        $this->loader->load($this->stateMachine);
        $this->stateMachine->setObject($this);
        $this->stateMachine->initialize();
    }

    public function accept($user_id)
    {
        if ($this->stateMachine->can('accept')) {

            $this->stateMachine->apply('accept');

            $this->order->update([
                'acceptor_user_id' => $user_id,
                'status' => $this->state,
            ]);
        }
    }

    public function areMaterialsStocked(): bool
    {
        $restMaterials = $this->order->materials->filter(function ($material) {
            return $material->need > $material->stock;
        });
        
        return $restMaterials->count() === 0;
    }
    
    public function finishStockMaterials()
    {
        if ($this->stateMachine->can('finish_stock_materials')) {
            $this->stateMachine->apply('finish_stock_materials');

            $this->order->update(['status' => $this->state]);
        }
    }

    public function finishStockSkills($worker)
    {
        if ($this->stateMachine->can('finish_stock_skills')) {
            $this->stateMachine->apply('finish_stock_skills');

            $this->order->update(['status' => $this->state]);

            OrderTransactions::transferOrderRewardToWorker($this->order, $worker);
        }
    }
}
