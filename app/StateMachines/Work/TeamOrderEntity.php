<?php

namespace App\StateMachines\Work;

use App\Exceptions\NotTeamLeaderException;
use App\Exceptions\WorkerWithoutTeamException;
use App\Models\Work\Team\TeamOrder;
use App\Models\Work\Worker;
use App\StateMachines\ApplicationEntity;

class TeamOrderEntity extends ApplicationEntity
{
    public function __construct(TeamOrder $order)
    {
        parent::__construct($order);
    }

    protected function getModelClass(): string
    {
        return TeamOrder::class;
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

    public function accept(Worker $worker)
    {
        if ($this->stateMachine->can('accept')) {


            $this->stateMachine->apply('accept');

            $this->model->update([
                'acceptor_team_id' => $worker->team_id,
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

    private function isAllMaterialsStocked(): bool
    {
        foreach ($this->model->materials as $material) {
            if ($material->need > $material->stock) {
                return false;
            }
        }

        return true;
    }
    
    public function finishStockMaterials()
    {
        if ($this->stateMachine->can('finish_stock_materials')) {
            $this->stateMachine->apply('finish_stock_materials');

            $this->model->update(['status' => $this->state]);
        }
    }

    public function checkFinishStockSkills()
    {
        if ($this->state === 'stock_skills' && $this->isAllSkillsStocked()) {

            if ($this->stateMachine->can('finish_stock_skills')) {
                $this->stateMachine->apply('finish_stock_skills');

                $this->model->update(['status' => $this->state]);
            }
        }
    }
    
    public function getMaterialByCode($code)
    {
        $materials = $this->model->materials;

        $index = $materials->search(function ($material, $key) use ($code) {
            return $material->code === $code;
        });

        if (is_int($index)) {
            return $materials->get($index);
        }

        return null;
    }

    public function getSkillByCode($code)
    {
        $index = $this->model->skills->search(function ($skill, $key) use ($code) {
            return $skill->code == $code;
        });

        if (is_int($index)) {
            return $this->model->skills->get($index);
        }

        return null;
    }

    public function isCompleted()
    {
        return $this->state === 'completed';
    }

    private function isAllSkillsStocked(): bool
    {
        foreach ($this->model->skills as $skill) {
            if ($skill->need_times > $skill->stock_times) {
                return false;
            }
        }

        return true;
    }
}
