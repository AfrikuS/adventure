<?php

namespace App\Commands\Employment\School;

use App\Domain\Services\Employment\Lore\LoreBuilderService;
use App\Domain\Services\Employment\Lore\LoreService;
use App\Persistence\Repositories\Employment\DomainsRepo;

class BuyLicenseCmd
{
    public function buyLicense($user_id, $domainCode)
    {
        /** @var DomainsRepo $domains */
        $domain = app('DomainRepo')->findByCode($domainCode);
        
        $loreRepo = app('LoreRepo');
//        $loreRepo->create
            
        $loreService = new LoreBuilderService();
        
        
        \DB::beginTransaction();
        try {


            $loreService->createLore($domainCode, $user_id);


        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }

}
