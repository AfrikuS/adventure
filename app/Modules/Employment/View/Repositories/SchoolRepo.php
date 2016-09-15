<?php

namespace App\Modules\Employment\View\Repositories;

use App\Modules\Employment\Persistence\Dao\DomainsDao;
use App\Modules\Employment\View\DataObjects\School\LoreLicense;

class SchoolRepo
{
    /** @var DomainsDao */
    private $domainsDao;

    public function __construct(DomainsDao $domainsDao)
    {
        $this->domainsDao = $domainsDao;
    }

    public function getLoreLicensesBy($user_id)
    {
        $licensesData = $this->domainsDao->getLoreLicenses($user_id);

        $licenses = [];

        foreach ($licensesData as $licenseData) {

            $license = new LoreLicense($licenseData);

            $licenses[] = $license;
        }

        return $licenses;
    }
}
