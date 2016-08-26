<?php

namespace App\Modules\Work\Domain\Entities\Order;

class OrderSkills
{
//    public $id;
//    public $order_id;
//    public $code;
//    public $needTimes;
//    public $stockTimes;
    
    private $skillsMap = [];

    public function __construct(array $orderSkillData)
    {
//        $this->id = $orderSkillData->id;
//        $this->order_id = $orderSkillData->order_id;
//        $this->code = $orderSkillData->code;
//        $this->needTimes = $orderSkillData->need_times;
//        $this->stockTimes = $orderSkillData->stock_times;
        
        $this->initSkillsMap($orderSkillData);
    }

    public function stockSkill($code, $amount = 1)
    {
        $this->skillsMap[$code]->stock += $amount;
    }

    private function initSkillsMap($orderSkillData)
    {
        foreach ($orderSkillData as $orderSkill) {

            $this->skillsMap[$orderSkill->code] = $orderSkill;
        }
    }
}
