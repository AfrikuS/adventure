<?php

namespace App\Modules\Employment\Persistence\Repositories;

use App\Infrastructure\CatalogsIdentityMap;
use App\Modules\Core\Facades\EntityStore;
use App\Modules\Employment\Domain\Entities\Domain;
use App\Modules\Employment\Domain\Entities\DomainsCatalog;
use App\Modules\Employment\Persistence\Catalogs\DomainsCollection;
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
        $domains = EntityStore::get(Domain::class, 'code'.$code);

        if ($domains != null) {
            return $domains;
        }

        $domainData = $this->domainDao->findByCode($code);

        $domain = new Domain($domainData);

        EntityStore::add($domains, 'code'.$code);

        return $domain;
    }

    public function getByUser($user_id)
    {
        $userDomains_ids = $this->loreDao->getDomainsIdsByUser($user_id);


        return $this->domainDao->getByIds($userDomains_ids);
    }

    /** @deprecated  */
    public function getAll()
    {
        
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

    public function getDomainsCollection()
    {
        $domains = EntityStore::get(DomainsCollection::class, 1);

        if ($domains != null) {
            return $domains;
        }

        $domainsData = $this->domainDao->getAll();

        $domains = new DomainsCollection();

        foreach ($domainsData as $domainData) {

            $domain = new Domain($domainData);

            $domains->addDomain($domain);
        }

        EntityStore::add($domains, 1);

        return $domains;
    }

    public function getUserRemainingsDomains($user_id)
    {
        $userDomains_ids = $this->loreDao->getDomainsIdsByUser($user_id);
        
        $domainsColl = $this->getDomainsCollection();
            
        $diffDomains = $domainsColl->differencesBy($userDomains_ids);
        
        return $diffDomains;
    }
}
