<?php

namespace App\Http\Controllers\Drive\Raid;

use App\Commands\Drive\Raid\FinishRaidCommand;
use App\Commands\Drive\Raid\Robbery\StartRobberyCommand;
use App\Entities\Drive\RaidEntity;
use App\Http\Controllers\Drive\DriveController;
use App\Lib\Drive\Raid\VictimFinder;
use App\Repositories\Drive\DriverRepository;
use App\Repositories\Drive\RaidRepository;
use Illuminate\Support\Facades\Input;

class RaidController extends DriveController
{
    /** @var RaidRepository */
    protected $raidRepo;

    /** @var RaidEntity */
    protected $raid;

    public function __construct(DriverRepository $driverRepo, RaidRepository $raidRepo)
    {
        parent::__construct($driverRepo);

        $this->raidRepo = $raidRepo;
        
        $this->raid = $this->raidRepo->findRaidById($this->driver->id);
    }

    public function show()
    {
        $raidStatus = $this->raid->status;
        
        switch ($raidStatus)
        {
            case 'switch_action':

                return $this->view('drive.raid.switch_action', [
                ]);

            case 'in_robbery':

                return \Redirect::route('drive_robbery_page');

            case 'search_victim':

                return $this->view('drive.raid.search_results', [
                    'raid' => $this->raid,
                ]);

            case 'repair':

                return $this->view('drive.raid.repair', [
                ]);
        }

    }    
    

    public function startRobbery()
    {
        $data = Input::all();
//        $raid_id   = $data['raid_id'];
        $victim_id = $data['victim_id'];
        
        
        $cmd = new StartRobberyCommand($this->raidRepo);

        $cmd->startRobbery($this->raid);
        
        
        
        return \Redirect::route('drive_robbery_page');
    }

    public function searchVictim()
    {
//        $victim_id = $this->driver->id;
//        $victims = $this->driver->id;
        $finder = new VictimFinder();

        $victim_id = $finder->findVictim($this->raid);


        if (null == $victim_id) {

            $this->raid->notFindVictim();

            return $this->view('drive.raid.search_empty', [
//                'victim_id' => $victim_id,
            ]);
        }
        
        $this->raid->findVictim($victim_id);

        return $this->view('drive.raid.search_results', [
            'raid' => $this->raid,
        ]);
    }

    public function finish()
    {
        $cmd = new FinishRaidCommand($this->raidRepo, $this->heroRepo);

        $cmd->finishRaid($this->raid);

        
        return \Redirect::route('drive_garage_vehicle_page');
    }

    public function vehicleBroken()
    {
        return $this->view('drive.raid.vehicle_broken', [
//            'raid' => $this->raid,
        ]);
    }
    

    protected function view($view = null, $data = [])
    {
//        $raid = $this->raidRepo->findRobberyById($this->driver->id);

        $data['raid'] = $this->raid;

        return parent::view($view, $data);
    }


}
