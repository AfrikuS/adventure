<?php

namespace App\Modules\Employment\Persistence\Repositories;

use App\Infrastructure\CatalogsIdentityMap;
use App\Modules\Employment\Domain\Entities\Domain;
use App\Modules\Employment\Domain\Entities\DomainsCatalog;
use App\Modules\Employment\Persistence\Dao\DomainDao;
use App\Modules\Employment\Persistence\Dao\LoreDao;

class DomainsRepo
{
    /** @var DomainDao */
    private $domainDao;
    
    /** @var LoreDao */
    private $loreDao;

    public function __construct(DomainDao $domainDao, LoreDao $loreDao)
    {
        $this->domainDao = $domainDao;
        $this->loreDao = $loreDao;
    }

    public function find($domain_id)
    {
        return $this->domainDao->find($domain_id);
    }

    public function getCodes()
    {
        return $this->domainDao->getCodes();
    }
    
    public function findByCode($code)
    {
        $domainData = $this->domainDao->findByCode($code);
        
        return 
            new Domain(
                $domainData->id,
                $domainData->code,
                $domainData->title,
                $domainData->mosaic_size
            );
    }

    public function getByUser($user_id)
    {
        $userDomains_ids = $this->loreDao->getDomainsIdsByUser($user_id);


        return $this->domainDao->getByIds($userDomains_ids);
    }
    
    public function getAll()
    {
        
    }

    public function getCatalog()
    {
        // object-entity level
        $domains = CatalogsIdentityMap::getInstance()->getCatalog('DomainsCatalog');

        if ($domains != null) {

            return $domains;
        }

        $domainsData = $this->domainDao->getAll();

        if (null == $domainsData) {

            throw new \Exception('no entries in table');
        }

        $domains = new DomainsCatalog($domainsData);


        CatalogsIdentityMap::getInstance()->addCatalog($domains);

        return $domains;
    }

    public function create($title, $code, $mosaicSize)
    {
        $this->domainDao->create($title, $code, $mosaicSize);
    }

    public function getDiffsDomainsByUser($user_id)
    {
        $userDomains_ids = $this->loreDao->getDomainsIdsByUser($user_id);
        
        return $this->domainDao->getDiffsUserDomains($userDomains_ids);
    }

}
