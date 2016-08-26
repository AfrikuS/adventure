<?php

namespace App\Modules\Employment\Domain\Services\Lore;

use App\Modules\Employment\Persistence\Repositories\LoreRepo;

class LoreService
{
    /** @var LoreRepo */
    private $loreRepo;

    public function __construct()
    {
        $this->loreRepo = app('LoreRepo');
    }


    public function attemptUpSkill($lore_id)
    {
    }
}
