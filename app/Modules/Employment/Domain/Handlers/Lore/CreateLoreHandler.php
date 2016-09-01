<?php

namespace App\Modules\Employment\Domain\Handlers\Lore;

use App\Modules\Employment\Persistence\Repositories\DomainsRepo;
use App\Modules\Employment\Persistence\Repositories\LoreRepo;

class CreateLoreHandler
{
    /** @var LoreRepo */
    private $loreRepo;
    
    /** @var DomainsRepo */
    private $domainsRepo;

    public function __construct()
    {
        $this->domainsRepo = app('DomainsRepo');
        
        $this->loreRepo = app('LoreRepo');
    }

    public function handle(CreateLore $command)
    {
        $domain = $this->domainsRepo->find($command->domain_id);
        
        $mosaic = $this->buildMosaic($domain->mosaic_size);
        
        $this->loreRepo->create(
            $command->user_id,
            $domain->id,
            $mosaic,
            $domain->mosaic_size 
        );
    }

    private function buildMosaic($size)
    {
        // строка нулей, разделенных запятыми
        $mosaicArr = array_fill(0, $size, 0);


        $mosaicStr = implode(",", $mosaicArr);

        return $mosaicStr;
    }

}
