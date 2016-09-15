<?php

namespace App\Modules\Employment\View\DataObjects\School;

class LoreLicense
{
    public $domain_id;
    public $domainTitle;
    public $isExist;

    public function __construct(\stdClass $licenseData)
    {
        $this->domain_id = $licenseData->domain_id;
        $this->domainTitle = $licenseData->domain_title;
        $this->isExist = $licenseData->is_exist !== null;
    }
}
