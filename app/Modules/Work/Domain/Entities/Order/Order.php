<?php

namespace App\Modules\Work\Domain\Entities\Order;

class Order
{
    const STATUS_FREE = 'free';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_COMPLETED = 'completed';
    const STATUS_STOCK_MATERIALS = 'stock_materials';
    const STATUS_STOCK_SKILLS = 'stock_skills';
//    const STATUS_CREATED = 'created';

    public $id;
    public $desc;
    public $type;
    public $status;
//    public $kind_work_title;
    public $domainCode;
    public $price;
    public $acceptor_worker_id;
    public $customer_hero_id;
    
    public $materials;

    public function __construct(\stdClass $orderData)
    {
        $this->id = $orderData->id;
        $this->desc = $orderData->desc;
        $this->type = $orderData->type;
        $this->status = $orderData->status;
//        $this->kind_work_title = $orderData->kind_work_title;
        $this->domainCode = $orderData->domain_code;
        $this->price = $orderData->price;
        $this->acceptor_worker_id = $orderData->acceptor_worker_id;
        $this->customer_hero_id = $orderData->customer_hero_id;
    }

    /**
     * @return mixed
     */
    public function getMaterials()
    {
        return $this->materials;
    }

    /**
     * @param mixed $materials
     */
    public function setMaterials($materials)
    {
        $this->materials = $materials;
    }

    

    public function setStockSkillsStatus()
    {
        $this->status = self::STATUS_STOCK_SKILLS;
    }

    public function setAcceptor($worker_id)
    {
        $this->acceptor_worker_id = $worker_id;
    }

//    public function changeStatusAfterAccepting()
//    {
//        $this->status = 'accepted';
//    }

    public function setStatusStockMaterials()
    {
        $this->status = self::STATUS_STOCK_MATERIALS;
    }

    public function setStatusAccepted()
    {
        $this->status = self::STATUS_ACCEPTED;
    }

    public function setStatusCompleted()
    {
        $this->status = self::STATUS_COMPLETED;
    }

    public function setStatusEstimated()
    {
        $this->setStatusStockMaterials();
    }

    public function setStatusStockedMaterials()
    {
        $this->setStockSkillsStatus();
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
        foreach ($this->materials->extract() as $material) {
            
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

            $this->status = self::STATUS_COMPLETED;
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
