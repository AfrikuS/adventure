<?php

namespace App\Modules\Drive\Exceptions\Controllers;

use App\Modules\Drive\Domain\Entities\Raid\Raid;

class SearchSuccess_Exception extends \Exception
{
    /** @var Raid */
    public $raid;

    public function __construct(Raid $raid)
    {
        $this->raid = $raid;
    }
}
