<?php

namespace App\Modules\Employment\Controllers\School;

use App\Commands\Employment\School\BuyLicenseCmd;
use App\Commands\Employment\School\ProcessSchoolTaskCmd;
use App\Http\Controllers\Employment\EmploymentController;
use App\Modules\Employment\Domain\Entities\DomainsCatalog;
use App\Modules\Employment\Persistence\Repositories\DomainsRepo;
use App\Modules\Employment\Persistence\Repositories\LoreRepo;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Facades\Input;

class SchoolController extends EmploymentController
{
    /** @var Dispatcher */
    protected $bus;

    public function __construct(Dispatcher $bus)
    {
        parent::__construct();

        $this->bus = $bus;
    }

    public function index()
    {
        // список курсов-школ доменных областей

//        $domains = domainsRepo->getDomainsCollection();
        /** @var LoreRepo $loreRepo */
        $loreRepo = app('LoreRepo');
        /** @var DomainsRepo $domainsRepo */
        $domainsRepo = app('DomainRepo');

        $remainingDomains_ids = $loreRepo->getRemainingDomainsByUser($this->user_id);


        /** @var DomainsCatalog $domainsCatalog */
        $domainsCatalog = app('DomainsCatalog');

        $remainingDomains = $domainsRepo->getDiffsDomainsByUser($this->user_id);
        
        
        $userDomains = $domainsRepo->getByUser($this->user_id);
        
//        $remainingDomains = $domainsCatalog->differencesByIds($remainingDomains_ids);


//        $command = new AddEmploymentDomain('Новая', 'new_domain', 15);




//        Bus::dispatch($command);

//        $this->bus->maps([AddEmploymentDomain::class => AddEmploymentDomainHandler::class.'@handle']);
//        $this->bus->dispatch($command);



        return $this->view('employment.school.index', [
            'remainingDomains' => $remainingDomains,
            'userDomains' => $userDomains,
        ]);
    }

    public function getLicense()
    {
        $data = Input::all();
        $domainCode = $data['code'];
        
        $a = app('LoreRepo');
        $cmd = new BuyLicenseCmd();
        
        $cmd->buyLicense($this->user_id, $domainCode);

        return \Redirect::route('employment_school_page');
    }

    public function classroom($domain_id)
    {
        /** @var LoreRepo $loreRepo */
        $loreRepo = app('LoreRepo');

        $lore = $loreRepo->findByUser($this->user_id, $domain_id);

        $mosaic = $lore->extractToViewDto();




        return $this->view('employment.school.classroom.index', [
            'mosaic' => $mosaic,
            'lore' => $lore,
        ]);
    }

    public function processSchoolTask()
    {
        $data = Input::all();

        $lore_id = $data['lore_id'];

        
        $processSchoolTask = new ProcessSchoolTaskCmd();

        $processSchoolTask->process($lore_id, $this->user_id);
        
//        $workProcess = new WorkProcessCmd();
//
//
//        $workProcess->workProcess($lore_id);




        return \Redirect::back();
//        return \Redirect::route('employment_index_page');
    }
}
