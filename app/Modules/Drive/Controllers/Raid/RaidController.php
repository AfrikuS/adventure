<?php

namespace App\Modules\Drive\Controllers\Raid;

use App\Http\Controllers\Controller;
use App\Modules\Drive\Actions\Raid\CompleteRaidCommand;
use App\Modules\Drive\Actions\Raid\Robbery\StartRobberyCommand;
use App\Modules\Drive\Actions\Raid\SearchVictimCommand;
use App\Modules\Drive\Actions\Raid\StartRaidCommand;
use App\Modules\Drive\Domain\Entities\Raid\Raid;
use App\Modules\Drive\Exceptions\Controllers\SearchFail_Exception;
use App\Modules\Drive\Exceptions\Controllers\SearchSuccess_Exception;
use App\Modules\Drive\Persistence\Repositories\Raid\RaidRepo;
use Illuminate\Support\Facades\Input;

class RaidController extends Controller
{
    /** @var RaidRepo */
    protected $raidRepo;

    public function __construct()
    {
        parent::__construct();

        $this->raidRepo = app('DriveRaidRepo');
    }

    public function show()
    {
        /** @var RaidRepo $raidRepo */
        $raidRepo = app('DriveRaidRepo');

        /** @var Raid $raid */
        $raid = $raidRepo->findSimpleRaid($this->user_id);
        $raidStatus = $raid->status;

        
        switch ($raidStatus)
        {
            case Raid::RAID_STATUS_FREE:

                return $this->view('drive.raid.switch_action', [
                ]);

            case Raid::RAID_STATUS_IN_ROBBERY:

                return \Redirect::route('drive_robbery_page');

            case Raid::RAID_STATUS_SEARCH_VICTIM:

                return $this->view('drive.raid.search_results', [
                    'raid' => $raid,
                ]);

            case Raid::RAID_STATUS_ON_REPAIR:

                return $this->view('drive.raid.repair', [
                ]);
        }

    }

    public function startRaid()
    {

        $cmd = new StartRaidCommand();

        $cmd->createRaid($this->user_id);


        return \Redirect::route('drive_raid_page');
    }



    public function startRobbery()
    {
        $data = Input::all();
//        $victim_id = $data['victim_id'];
        $victim_id = $this->user_id;
        
        $cmd = new StartRobberyCommand();

        $cmd->startRobbery($this->user_id, $victim_id);
        
        
        
        return \Redirect::route('drive_robbery_page');
    }

    public function searchVictim()
    {
        $searchVictim = new SearchVictimCommand();
        
        
        try {

            $searchVictim->searchVictim($this->user_id);
        }
        catch (SearchSuccess_Exception $e) {



//            return \Redirect::route('view_victim_page', ['victim_id']);
            return $this->view('drive.raid.search_results', [
                'raid' => $e->raid,
            ]);
        }
        catch (SearchFail_Exception $e) {

            return $this->view('drive.raid.search_empty');
        }

    }

    public function finish()
    {
        $cmd = new CompleteRaidCommand;

        $cmd->completeRaid($this->user_id);

        
        return \Redirect::route('drive_garage_vehicle_page');
    }

    public function vehicleBroken()
    {
        return $this->view('drive.raid.vehicle_broken');
    }

    protected function view($view = null, $data = [])
    {
//        $raid = $this->raidRepo->findRobberyById($this->driver->id);
        /** @var RaidRepo $raidRepo */
        $raidRepo = app('DriveRaidRepo');

        $raid = $raidRepo->findSimpleRaid($this->user_id);
        $data['raid'] = $raid;

        return parent::view($view, $data);
    }
}
