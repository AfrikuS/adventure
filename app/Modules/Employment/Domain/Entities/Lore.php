<?php

namespace App\Modules\Employment\Domain\Entities;

class Lore
{
    const MAX_IN_GAME_SKILL_VALUE = 10;
    const MAX_IN_SCHOOL_SKILL_VALUE = 3;
    const DELIMETER = ':';

    public $id;
    
    public $user_id;

    public $mosaic;
    
    public $size;

    public $domain_id;
    public $domain_code;

    public function __construct(\stdClass $loreData)
    {
        $this->id = $loreData->id;
        $this->user_id = $loreData->user_id;
        $this->size = $loreData->size;
        $this->domain_id = $loreData->domain_id;
        $this->domain_code = $loreData->domain_code;

        $this->unpackMosaic($loreData->mosaic);
    }

    public function upUnitOfLore($index)
    {
        $this->mosaic[$index] += 1;
    }

    public function getValue($index)
    {
        return $this->mosaic[$index];
    }

    public function extractToViewDto()
    {
        $mosaicStr = implode(' : ', $this->mosaic);
        
        return $mosaicStr;
    }

    public function isMaxValue($index)
    {
        return $this->mosaic[$index] == Lore::MAX_IN_GAME_SKILL_VALUE;
    }

    public function isMaxInSchoolValue($index)
    {
        return $this->mosaic[$index] >= Lore::MAX_IN_SCHOOL_SKILL_VALUE;
    }

    private function unpackMosaic($mosaic)
    {
        $this->mosaic = explode(',', $mosaic);
    }
}
