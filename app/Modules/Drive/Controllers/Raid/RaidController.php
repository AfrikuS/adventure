<?php

namespace App\Modules\Drive\Controllers\Raid;

use App\Lib\Drive\Raid\VictimFinder;
use App\Modules\Drive\Commands\Raid\CompleteRaidCommand;
use App\Modules\Drive\Commands\Raid\Robbery\StartRobberyCommand;
use App\Modules\Drive\Commands\Raid\SearchVictimCommand;
use App\Modules\Drive\Controllers\DriveController;
use App\Modules\Drive\Domain\Entities\Raid\Raid;
use App\Modules\Drive\Exceptions\Controllers\SearchFail_Exception;
use App\Modules\Drive\Exceptions\Controllers\SearchSuccess_Exception;
use App\Modules\Drive\Persistence\Repositories\Raid\RaidRepo;
use App\Repositories\Drive\DriverRepository;
use App\Repositories\Drive\RaidRepository;
use Illuminate\Support\Facades\Input;

class RaidController extends DriveController
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
