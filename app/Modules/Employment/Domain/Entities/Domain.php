<?php

namespace App\Modules\Employment\Domain\Entities;

class Domain
{
    public $id;
    public $code;
    public $title;
    public $mosaic_size;

    public function __construct(\stdClass $domainData)
    {
        $this->id = $domainData->id;
        $this->code = $domainData->code;
        $this->title = $domainData->title;
        $this->mosaic_size = $domainData->mosaic_size;
    }
}
