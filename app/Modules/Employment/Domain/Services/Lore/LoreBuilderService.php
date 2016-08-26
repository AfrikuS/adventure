<?php

namespace App\Modules\Employment\Domain\Services\Lore;

use App\Handlers\Commands\Employment\CreateLore;
use App\Modules\Employment\Persistence\Repositories\DomainsRepo;
use App\Modules\Employment\Persistence\Repositories\LoreRepo;
use Illuminate\Support\Facades\Bus;

class LoreBuilderService
{
    /** @var LoreRepo */
    private $loreRepo;

    public function __construct()
    {
        $this->loreRepo = app('LoreRepo');
    }

    public function createLore($domainCode, $user_id)
    {
        /** @var DomainsRepo $domain */
        $domain = app('DomainRepo')->findByCode($domainCode);
        

        $command = new CreateLore($user_id, $domain);
        
        Bus::dispatch($command);
        
    }

}
