<?php

namespace App\Entities\Work;

use App\Models\Work\Order;
use App\Entities\ApplicationEntity;

class OrderEntity extends ApplicationEntity
{
    use OrderWithMaterialsTrait;
    use OrderWithSkillsTrait;

    public function __construct(Order $order)
    {
        parent::__construct($order);
    }

    protected function getModelClass(): string
    {
        return Order::class;
    }

    protected function getStates(): array
    {
        return [
            'free'            => ['type' => 'initial', 'properties' => []],
            'accepted'        => ['type' => 'normal',  'properties' => []],
            'stock_materials' => ['type' => 'normal',  'properties' => []],
            'stock_skills'    => ['type' => 'normal',  'properties' => []],
            'completed'       => ['type' => 'final',   'properties' => []],
        ];
    }

    protected function getTransitions(): array
    {
        return [
            'accept'  =>                ['from' => ['free'],            'to' => 'accepted'],
            'estimate'  =>              ['from' => ['accepted'],        'to' => 'stock_materials'],
            'finish_stock_materials' => ['from' => ['stock_materials'], 'to' => 'stock_skills'],
            'finish_stock_skills'  =>   ['from' => ['stock_skills'],    'to' => 'completed'],
        ];
    }

    public function haveAcceptor()
    {
        return is_int($this->model->acceptor_worker_id);
    }

    public function accept($worker_id)
    {
        if ($this->stateMachine->can('accept')) {
            $this->stateMachine->apply('accept');

            $this->model->update([
                'acceptor_worker_id' => $worker_id,
                'status' => $this->state,
            ]);
        }
    }

    public function estimate()
    {
        if ($this->stateMachine->can('estimate')) {
            $this->stateMachine->apply('estimate');

            $this->model->update(['status' => $this->state]);
        }
    }

    public function checkStockMaterials()
    {
        if ($this->state === 'stock_materials' && $this->isAllMaterialsStocked()) {
            $this->finishStockMaterials();
        }
    }

    public function finishStockMaterials()
    {
        if ($this->stateMachine->can('finish_stock_materials')) {
            $this->stateMachine->apply('finish_stock_materials');

            $this->model->update(['status' => $this->state]);
        }
    }

    public function isReadyToWorks()
    {
        return $this->state === 'stock_skills';
    }

    public function finishStockSkills()
    {
        if ($this->stateMachine->can('finish_stock_skills')) {
            $this->stateMachine->apply('finish_stock_skills');
            
            $this->model->update(['status' => $this->state]);
        }
    }
}
