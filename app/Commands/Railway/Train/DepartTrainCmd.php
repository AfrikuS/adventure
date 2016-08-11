<?php

namespace App\Commands\Railway\Train;

use App\Entities\Railway\ConductorSessionEntity;
use App\Models\Npc\ConductorSession;
use App\Models\Railway\TransitTrain;
use App\Repositories\Railway\Station\ConductorRepo;
use App\Repositories\Railway\TrainRepo;

class DepartTrainCmd
{
    /** @var TrainRepo */
    protected $trainRepo;
    /** @var ConductorRepo */
    protected $conductorRepo;

    public function __construct()
    {
        $this->trainRepo = new TrainRepo();
        $this->conductorRepo = new ConductorRepo();
    }

    public function departTrain($hero_id)
    {
        /** @var ConductorSessionEntity $meeting */
        $meeting = $this->conductorRepo->findMeetingByHeroId($hero_id);
        
        $train = $this->trainRepo->finById($meeting->train_id);

        
        \DB::beginTransaction();
        try {

            $conductorSessionCmd = new FinishConductorSessionCmd();

            $conductorSessionCmd->finishSession($hero_id, $meeting);



            $this->conductorRepo->deleteSession($meeting);

            $this->trainRepo->deleteTrain($train);
            
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }
}
