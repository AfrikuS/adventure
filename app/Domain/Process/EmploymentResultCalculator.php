<?php

namespace App\Domain\Process;

class EmploymentResultCalculator
{
    public static function calculateFoodObtain($peopleCount, $stavka)
    {
        // результат depends on people_count, by level of development of the food industry (farms count, it's level
        // every level - incrs on 3 %
        // skills of people in food industry
//        $farm = Farm::get($user_id);
//        $farm->level * 0.03 %
        $resValue = $stavka * (int) $peopleCount;

        return $resValue;
    }
}
