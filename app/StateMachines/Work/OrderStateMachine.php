<?php

namespace App\StateMachines\Work;

use App\Models\Work\Order;
use App\StateMachines\ApplicationEntity;

class OrderStateMachine extends ApplicationEntity
{
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
            'accepted'        => ['type' => 'normal', 'properties' => []],
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
        return is_int($this->model->acceptor_user_id);
    }

    public function isReadyToWorks()
    {
        return $this->state === 'stock_skills';
    }

    
    public function getMaterialByCode($code)
    {
        $materials = $this->model->materials; //!= null ? $this->materials : $this->model->materials()->get(['id', 'code', 'need', 'stock']);

        $index = $materials->search(function ($material, $key) use ($code) {
            return $material->code === $code;
        });

        if (is_int($index)) {
            return $materials->get($index);
        }

        return null;
    }

    public function checkStockMaterials()
    {
        if ($this->state === 'stock_materials' && $this->isAllMaterialsStocked()) {
            $this->finishStockMaterials();
        }
    }

    public function accept($user_id)
    {
        if ($this->stateMachine->can('accept')) {
            $this->stateMachine->apply('accept');

            $this->model->update([
                'acceptor_user_id' => $user_id,
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

    private function isAllMaterialsStocked(): bool
    {
        $remainingsMaterials = $this->model->materials->filter(function ($material) {
            return $material->need > $material->stock;
        });
        
        return $remainingsMaterials->count() === 0;
    }
    
    public function finishStockMaterials()
    {
        if ($this->stateMachine->can('finish_stock_materials')) {
            $this->stateMachine->apply('finish_stock_materials');

            $this->model->update(['status' => $this->state]);
        }
    }

    public function finishStockSkills()
    {
        if ($this->stateMachine->can('finish_stock_skills')) {
            $this->stateMachine->apply('finish_stock_skills');
            
            $this->model->update(['status' => $this->state]);
        }
    }
}
