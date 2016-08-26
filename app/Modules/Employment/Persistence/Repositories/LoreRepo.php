<?php

namespace App\Modules\Employment\Persistence\Repositories;

use App\Infrastructure\IdentityMap;
use App\Modules\Core\Facades\EntityStore;
use App\Modules\Employment\Domain\Entities\Lore;
use App\Modules\Employment\Domain\Entities\LoreDto;
use App\Modules\Employment\Persistence\Dao\DomainDao;
use App\Modules\Employment\Persistence\Dao\LoreDao;

class LoreRepo
{
    /** @var LoreDao */
    private $loreDao;

    /** @var DomainDao */
    private $domainDao;

    public function __construct(LoreDao $loreDao, DomainDao $domainDao)
    {
        $this->loreDao = $loreDao;
        $this->domainDao = $domainDao;
    }

    public function create($user_id, $domain_id, $mosaic, $size)
    {
        $this->loreDao->create($user_id, $domain_id, $mosaic, $size);
    }

/*    public function findByUser($user_id, $domain_id)
    {
        $lore = EntityStore::get(Lore::class, $user_id.':'.$domain_id);

        if (null !== $lore) {
            return $lore;
        }

        $loreData = $this->loreDao->findByUser($user_id, $domain_id);


        $lore = new Lore($loreData);


        EntityStore::add($lore, $user_id.':'.$domain_id);

        return $lore;
    }*/


    public function find($code, $user_id)
    {
        $lore = EntityStore::get(Lore::class, $code.'-'.$user_id);

        if ($lore != null) {

            return $lore;
        }

        // data-object

        $loreData = $this->loreDao->find($code, $user_id);

        $lore = new Lore($loreData);
//        $loreMosaicSize = strlen($loreData->mosaic);


        EntityStore::add($lore, $code.'-'.$user_id);

        return $lore;
    }

    /** @deprecated  */
    public function getViewLore($user_id)
    {
        $lore = $this->loreDao->findByUser($user_id);

        return new LoreDto($user_id, $lore->mosaic);
    }

    public function updateMosaic($lore)
    {
        $packedMosaic = implode(',', $lore->mosaic);

        $lore->mosaic = $packedMosaic;

        $this->loreDao->update($lore);
    }

    public function getRemainingDomainsByUser($user_id)
    {
        $allDomains = $this->domainDao->getAll();

        $allDomains_ids = array_map(function ($domain) {
            return $domain->id;
        }, $allDomains);

        $userLores = $this->loreDao->getByUser($user_id);

        $userDomains_ids = array_map(function ($lore) {
            return $lore->domain_id;
        }, $userLores);

        $remainings = array_diff($allDomains_ids, $userDomains_ids);
        
        return $remainings;
    }
}
