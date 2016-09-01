<?php

namespace App\Modules\Employment\Actions;

use App\Modules\Employment\Domain\Services\Lore\LoreBuilderService;
use App\Modules\Employment\Persistence\Repositories\DomainsRepo;

class BuyLicenseCmd
{
    public function buyLicense($user_id, $domain_id)
    {
//        /** @var DomainsRepo $domains */
//        $domain = app('DomainsRepo')->find($domain_id);
        
        $loreService = new LoreBuilderService();
        
        
        \DB::beginTransaction();
        try {


            $loreService->createLore($user_id, $domain_id);


        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }
}
