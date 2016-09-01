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

    public function createLore($user_id, $domain_id)
    {
//        /** @var DomainsRepo $domain */
//        $domain = app('DomainsRepo')->find($domain_id);
        

        $command = new CreateLore($user_id, $domain_id);
        
        Bus::dispatch($command);
        
    }

}
