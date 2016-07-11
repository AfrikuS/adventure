<?php

namespace App\Entities\Work;

use App\Commands\Work\TeamOrder\DeleteTeamOrderCommand;
use App\Models\Work\Order;
use App\Models\Work\Team\TeamOrder;
use App\Entities\ApplicationEntity;

class TeamOrderDraftEntity extends ApplicationEntity
{
    use OrderWithMaterials;
    use OrderWithSkillsTrait;
    
    public function __construct(Order $order)
    {
        parent::__construct($order);
    }

    public function getMaterialsCodes()
    {
        $materials = $this->model->materials;
        $codes = $materials->lists('code')->toArray();
        return $codes;
    }

    public function getSkillsCodes()
    {
        $skillScodes = $this->model->skills->lists('code')->toArray();

        return $skillScodes;
    }

    public function deleteOldSkills($deleteSkillsCodes)
    {
        $this->model->skills()->whereIn('code', $deleteSkillsCodes)->delete();

    }

    public function addSkill($skill)
    {
        $this->model->skills->push($skill);

    }

    public function deleteOldMaterials($deleteMaterialsCodes)
    {
        $this->model->materials()->whereIn('code', $deleteMaterialsCodes)->delete();

    }

    public function addMaterial($checkedMaterial)
    {
        $this->model->materials->push($checkedMaterial);
    }

    public function publish()
    {
        if ($this->stateMachine->can('publish')) {
            $this->stateMachine->apply('publish');

            $this->model->update(['status' => $this->state]);
        }
    }
    

    public function fillSkillValueByCode(string $code, int $value)
    {
        $skill = $this->getSkillByCode($code);
        $skill->update(['need_times' => $value]);
    }
    
    public function fillMaterialValueByCode($code, $value)
    {
        $material = $this->getMaterialByCode($code);
        $material->update(['need' => $value]);
    }

    public function delete()
    {
        if ($this->state == 'draft') {
        }
    }

    public function fillOrderData($orderValues)
    {
        if ($this->state == 'draft') {
            if (!isset($orderValues['kind_work_title'])) {
                $orderValues['kind_work_title'] = 'pokraska';
            }
            $this->model->update([
                'price' => $orderValues['price'],
                'kind_work_title' => $orderValues['kind_work_title'],
                'desc' => $orderValues['desc'],
            ]);
        }
    }

    // copy-paste from teamorder-entity

    
    protected function getModelClass(): string
    {
        return Order::class;
    }

    protected function getStates(): array
    {
        return [
            'draft'            => ['type' => 'initial', 'properties' => []],
//            'accepted'        => ['type' => 'normal',  'properties' => []],
//            'stock_materials' => ['type' => 'normal',  'properties' => []],
//            'stock_skills'    => ['type' => 'normal',  'properties' => []],
            'free'       => ['type' => 'final',   'properties' => []],
        ];
    }

    protected function getTransitions(): array
    {
        return [
            'publish'  =>                ['from' => ['draft'],            'to' => 'free'],
//            'estimate'  =>              ['from' => ['accepted'],        'to' => 'stock_materials'],
//            'finish_stock_materials' => ['from' => ['stock_materials'], 'to' => 'stock_skills'],
//            'finish_stock_skills'  =>   ['from' => ['stock_skills'],    'to' => 'completed'],
        ];
    }
}
