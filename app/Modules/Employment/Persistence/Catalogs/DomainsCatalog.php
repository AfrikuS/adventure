<?php

namespace App\Modules\Employment\Domain\Entities;

/** @deprecated  */
class DomainsCatalog
{
    /** @var array */
    private $domainsMap;

    public function __construct(array $domains)
    {
        $this->convertToMap($domains);
    }

    public function getByCode($code)
    {
        if (isset($this->domainsMap[$code])) {

            return $this->domainsMap[$code];
        }

        throw new \Exception('entry not found');
    }

    private function convertToMap($domains)
    {
        foreach ($domains as $domain) {

            $this->domainsMap[$domain->code] = $domain;
        }
    }

    /** @deprecated  */
    public function differencesByIds(array $remaining_ids)
    {
        $remainings = array_filter($this->domainsMap, function ($domain) use ($remaining_ids) {
            return in_array($domain->id, $remaining_ids);
        });
        
        return $remainings;
    }


}
