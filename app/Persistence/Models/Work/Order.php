<?php

namespace App\Persistence\Models\Work;

use App\Persistence\Models\DataObject;

class Order extends DataObject
{
    public function setStockSkillsStatus()
    {
        $this->dataObject->status = 'stock_skills';
    }

    public function setAcceptor($worker_id)
    {
        $this->dataObject->acceptor_worker_id = $worker_id;
    }

//    public function changeStatusAfterAccepting()
//    {
//        $this->dataObject->status = 'accepted';
//    }

    public function setStatusStockMaterials()
    {
        $this->dataObject->status = 'stock_materials';
    }

    public function setStatusAccepted()
    {
        $this->dataObject->status = 'accepted';
    }

    public function setStatusCompleted()
    {
        $this->dataObject->status = 'completed';
    }

    protected function getAttributes()
    {
        return ['id', 'desc', 'type', 'status', 'kind_work_title', 'price',
                'acceptor_worker_id', 'acceptor_team_id', 'customer_hero_id',
        
                'materials'];
    }

    // redo to checker
    public function isStockCompleted(): bool
    {
        foreach ($this->dataObject->materials->extract() as $material) {
            
            if ($material->need != $material->stock) {
                
                return false;
            }
        }

        return true;
    }


    public function finishStockSkills()
    {
/*        if ($this->stateMachine->can('finish_stock_skills')) {
            $this->stateMachine->apply('finish_stock_skills');*/

            $this->dataObject->status = 'completed';
/*            $this->model->update(['status' => $this->state]);
        }*/

    }


    public function getNeedMaterialAmount($code)
    {
        $material = $this->findMaterialByCode($code); // $this->materials->findByCode($code);

        return $material->need;
    }

    public function findMaterialByCode($code)
    {
        $material = array_filter($this->materials, function ($material) use ($code) {
            return $material->code === $code;
        });

        if (count($material) != 1)  {
            throw new \Exception;
        }

        return array_pop($material);
    }
}
