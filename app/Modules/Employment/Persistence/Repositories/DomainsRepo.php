<?php

namespace App\Modules\Employment\Persistence\Repositories;

use App\Infrastructure\CatalogsIdentityMap;
use App\Modules\Core\Facades\EntityStore;
use App\Modules\Employment\Domain\Entities\Domain;
use App\Modules\Employment\Domain\Entities\DomainsCatalog;
use App\Modules\Employment\Persistence\Catalogs\DomainsCollection;
use App\Modules\Employment\Persistence\Dao\DomainsDao;
use App\Modules\Employment\Persistence\Dao\LoreDao;
use App\Modules\Employment\View\DataObjects\School\LoreLicense;

class DomainsRepo
{
    /** @var DomainsDao */
    private $domainsDao;
    
    /** @var LoreDao */
    private $loreDao;

    public function __construct(DomainsDao $domainsDao, LoreDao $loreDao)
    {
        $this->domainsDao = $domainsDao;
        $this->loreDao = $loreDao;
    }

    public function find($domain_id)
    {
        return $this->domainsDao->find($domain_id);
    }

    public function findByCode($code)
    {
        $domains = EntityStore::get(Domain::class, 'code'.$code);

        if ($domains != null) {
            return $domains;
        }

        $domainData = $this->domainsDao->findByCode($code);

        $domain = new Domain($domainData);

        EntityStore::add($domains, 'code'.$code);

        return $domain;
    }

    public function getByUser($user_id)
    {
        $userDomains_ids = $this->loreDao->getDomainsIdsByUser($user_id);


        return $this->domainsDao->getByIds($userDomains_ids);
    }

    public function create($title, $code, $mosaicSize)
    {
        $this->domainsDao->create($title, $code, $mosaicSize);
    }

    /** @deprecated  */
    public function getDiffsDomainsByUser($user_id)
    {
        $userDomains_ids = $this->loreDao->getDomainsIdsByUser($user_id);
        
        return $this->domainsDao->getDiffsUserDomains($userDomains_ids);
    }

    public function getDomainsCollection()
    {
        $domains = EntityStore::get(DomainsCollection::class, 1);

        if ($domains != null) {
            return $domains;
        }

        $domainsData = $this->domainsDao->getAll();

        $domains = new DomainsCollection();

        foreach ($domainsData as $domainData) {

            $domain = new Domain($domainData);

            $domains->addDomain($domain);
        }

        EntityStore::add($domains, 1);

        return $domains;
    }
}
