<?php

namespace App\Repositories\Drive;

use App\Entities\Drive\RaidEntity;
use App\Entities\Drive\RobberyEntity;
use App\Models\Drive\Raid;
use App\Repositories\HeroRepositoryObj;
use Carbon\Carbon;

class RaidRepository
{

    public function createRobberyFromRaid(RaidEntity $raid, $victim_id)
    {
        $heroRepo = new HeroRepositoryObj();
        $hero = $heroRepo->findHeroWithBuildings($victim_id);
            // redo todo !!!!!!
        if (null == $hero->getRelation('buildings')) {
            $heroRepo->createBuildings($victim_id);
        }


        // todo review/ danger !!
        $robbery = $this->findRobberyById($raid->id);

        $robbery->update([
            'victim_id' => $victim_id,
            'robbery_status' => 'far_gates',
        ]);

        return $robbery;
    }

    public function findSimpleRaidById($id)
    {
        return Raid::select('id', 'vehicle_id', 'status', 'reward', 'start_raid')->find($id);
    }

    public function findRaidById($id)
    {
//        $raid = $this->findSimpleRaidById($id);
        $raid = Raid::select('id', 'vehicle_id', 'status',
                    'victim_id', 'robbery_status', 'reward', 'start_raid')->find($id);

        return new RaidEntity($raid);
    }

    public function findRobberyById($id)
    {
        return Raid::select('id', 'vehicle_id', 'victim_id', 'robbery_status')->find($id);
    }

    public function findRobberyByDriverId($driver_id)
    {
        $robbery = $this->findRobberyById($driver_id);
        
        return new RobberyEntity($robbery);
    }

    public function deleteRobberyById($id)
    {
        $robbery = $this->findRobberyById($id);

        $robbery->update([
            'victim_id' => null,
            'robbery_status' => null,
        ]);
    }

    public function createRaid($driver_id, $vehicle_id, string $startTime)
    {
        return Raid::create([
            'id'         => $driver_id,
            'vehicle_id' => $vehicle_id,
            'status'     => 'switch_action',
            'reward'     => 0,
            'start_raid' => $startTime,
        
            'victim_id' => null,
            'robbery_status' => null,
        ]);
    }

    public function deleteRaid($id)
    {
        return Raid::destroy($id);
    }

}
