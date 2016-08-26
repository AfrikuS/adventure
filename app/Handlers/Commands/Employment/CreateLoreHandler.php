<?php

namespace App\Handlers\Commands\Employment;

use App\Persistence\Repositories\Employment\DomainsRepo;
use App\Persistence\Repositories\Employment\LoreRepo;

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
        $domain = $this->domainsRepo->findByCode($command->domainCode);
        
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
