<?php

namespace App\Modules\Work\Domain\Entities\Order;

class OrderSkill
{
    public $id;
    public $order_id;
    public $code;
    public $needTimes;
    public $stockTimes;

    public function __construct(\stdClass $orderSkillData)
    {
        $this->id = $orderSkillData->id;
        $this->order_id = $orderSkillData->order_id;
        $this->code = $orderSkillData->code;
        $this->needTimes = $orderSkillData->need_times;
        $this->stockTimes = $orderSkillData->stock_times;
    }

    public function stock()
    {
        $this->stockTimes++;
    }

    public function isFullStock()
    {
        return $this->needTimes === $this->stockTimes;
    }
}
