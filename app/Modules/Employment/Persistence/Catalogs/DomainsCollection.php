<?php

namespace App\Modules\Employment\Persistence\Catalogs;

use App\Modules\Employment\Domain\Entities\Domain;
use App\Modules\Employment\View\DataObjects\School\LoreLicense;

class DomainsCollection
{
    public $domains;

    public function __construct()
    {
        $this->domains = [];
    }

    public function addDomain(Domain $domain)
    {
        $this->domains[$domain->id] = $domain;
    }

    public function find($id)
    {
        return $this->domains[$id];
    }

    public function getIds()
    {
        return array_keys($this->domains);
    }

    /** @deprecated  */ // intersect-filter realise
    public function differencesBy($domains_ids)
    {
//        $allDomains_ids = array_keys($this->domains);
//        $diffs_ids = array_diff($allDomains_ids, $domains_ids);
//        fore

        $diffsDomains = array_filter($this->domains, function ($domain) use ($domains_ids) {
            return ! in_array($domain->id, $domains_ids);
        });

        $userLicenses = [];

        foreach ($this->domains as $domain) {

            $license = new LoreLicense(
                $domain->id,
                $domain->title,
                in_array($domain->id, $domains_ids)
            );

            $userLicenses[] = $license;
        }
        
        return $userLicenses;
    }
}
