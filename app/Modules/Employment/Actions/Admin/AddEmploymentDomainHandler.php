<?php

namespace App\Handlers\Commands;


use App\Modules\Employment\Persistence\Repositories\DomainsRepo;

class AddEmploymentDomainHandler
{
    /** @var DomainsRepo */
    private $domainRepo;

    public function __construct(DomainsRepo $domainRepo)
    {
        $this->domainRepo = $domainRepo;
    }

    public function handle(AddEmploymentDomain $command)
    {

        $this->domainRepo->create(
            $command->title,
            $command->code,
            $command->mosaicSize
        );
    }
}
