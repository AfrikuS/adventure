<?php

namespace App\Modules\Employment\Persistence\Dto;

class LoreProgress
{
    public $id;
//    public $code;
    public $title;
    public $isLicense;

    public function __construct($domain_id, $domain_code, $isLicense)
    {
        $this->id = $domain_id;
        $this->title = $domain_code;
        $this->isLicense = $isLicense;
    }
}
