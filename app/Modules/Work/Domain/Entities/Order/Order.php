<?php

namespace App\Modules\Work\Domain\Entities\Order;

class Order
{
    const STATUS_FREE = 'free';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_COMPLETED = 'completed';
    const STATUS_STOCK_MATERIALS = 'stock_materials';
    const STATUS_STOCK_SKILLS = 'stock_skills';

    const TYPE_INDIVIDUAL = 'individual';

    public $id;
    public $desc;
    public $type;
    public $status;
    public $domain_id;
    public $price;
    public $acceptor_worker_id;
    public $customer_hero_id;

    /** @var OrderMaterialsCollection */
    public $materials;

    /** @var OrderSkill */
    public $skill;

    public function __construct(\stdClass $orderData)
    {
        $this->id = $orderData->id;
        $this->desc = $orderData->desc;
        $this->type = $orderData->type;
        $this->domain_id = $orderData->domain_id;
        
        $this->status = $orderData->status;
        $this->price = $orderData->price;
        $this->acceptor_worker_id = $orderData->acceptor_worker_id;
        $this->customer_hero_id = $orderData->customer_hero_id;
    }

    public function setMaterials(OrderMaterialsCollection $materials)
    {
        $this->materials = $materials;
    }

    public function setSkill(OrderSkill $skill)
    {
        $this->skill = $skill;
    }

    

    public function setStockSkillsStatus()
    {
        $this->status = self::STATUS_STOCK_SKILLS;
    }

    public function setAcceptor($worker_id)
    {
        $this->acceptor_worker_id = $worker_id;
    }

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
    
    public function finishStockSkills()
    {
        $this->status = self::STATUS_COMPLETED;
    }
}
