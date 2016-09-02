<?php

namespace App\Modules\Employment\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Modules\Employment\Actions\BuyLicenseCmd;
use App\Modules\Employment\Actions\School\ProcessSchoolTaskCmd;
use App\Modules\Employment\Persistence\Repositories\LoreRepo;
use App\Modules\Employment\View\Repositories\SchoolRepo;
use Illuminate\Support\Facades\Input;

class SchoolController extends Controller
{
    public function index()
    {
        /** @var SchoolRepo $schoolRepo */
        $schoolRepo = app('SchoolRepo');


        $userLicenses = $schoolRepo->getLoreLicensesBy($this->user_id);

        return $this->view('employment.school.index', [
            'userLicenses' => $userLicenses,
        ]);
    }

    public function getLicense()
    {
        $data = Input::all();
        $domain_id = $data['domain_id'];
        
        $cmd = new BuyLicenseCmd();
        
        $cmd->buyLicense($this->user_id, $domain_id);

        return \Redirect::route('employment_school_page');
    }

    public function classroom($domain_id)
    {
        /** @var LoreRepo $loreRepo */
        $loreRepo = app('LoreRepo');

        $lore = $loreRepo->findBy($this->user_id, $domain_id);




        return $this->view('employment.school.classroom.index', [
            'lore' => $lore,
        ]);
    }

    public function processSchoolTask()
    {
        $data = Input::all();

        $lore_id = $data['lore_id'];

        
        $processSchoolTask = new ProcessSchoolTaskCmd();

        $processSchoolTask->process($this->user_id, $lore_id);
        
        
        return \Redirect::back();
    }
}
