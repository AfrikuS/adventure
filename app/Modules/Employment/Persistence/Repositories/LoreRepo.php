<?php

namespace App\Modules\Employment\Persistence\Repositories;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Employment\Domain\Entities\Lore;
use App\Modules\Employment\Persistence\Dao\DomainsDao;
use App\Modules\Employment\Persistence\Dao\LoreDao;

class LoreRepo
{
    /** @var LoreDao */
    private $loresDao;

    /** @var DomainsDao */
    private $domainsDao;

    public function __construct(LoreDao $loreDao, DomainsDao $domainDao)
    {
        $this->loresDao = $loreDao;
        $this->domainsDao = $domainDao;
    }

    public function create($user_id, $domain_id, $mosaic, $size)
    {
        $this->loresDao->create($user_id, $domain_id, $mosaic, $size);
    }

    public function find($lore_id)
    {
        $lore = EntityStore::get(Lore::class, $lore_id);

        if ($lore != null) {

            return $lore;
        }

        $loreData = $this->loresDao->find($lore_id);

        $lore = new Lore($loreData);


        EntityStore::add($lore, $lore->id);

        return $lore;
    }

    /** @deprecated  */
    public function findBy($user_id, $domain_id)
    {
        $lore = EntityStore::get(Lore::class, $domain_id.'-'.$user_id);

        if ($lore != null) {
            return $lore;
        }

        
        $loreData = $this->loresDao->findBy($user_id, $domain_id);

        $lore = new Lore($loreData);


        EntityStore::add($lore, $domain_id.'-'.$user_id);

        return $lore;
    }

    public function isHaveLoreDomain($worker, $domain_id)
    {
        return $this->loresDao->isExistBy($worker, $domain_id);
    }

    public function updateMosaic(Lore $lore)
    {
        $packedMosaic = $lore->getPackedMosaicForDb();
        
        $this->loresDao->update(
            $lore->id, 
            $packedMosaic
        );
    }

    public function getBy($user_id)
    {
        $loresData = $this->loresDao->getByUser($user_id);
        
        return $loresData;
    }
}
