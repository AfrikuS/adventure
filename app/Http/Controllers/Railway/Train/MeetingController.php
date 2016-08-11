<?php

namespace App\Http\Controllers\Railway\Train;

use App\Entities\Railway\ConductorSessionEntity;
use App\Models\Npc\ConductorSession;
use App\Repositories\Railway\Station\ConductorRepo;
use App\Repositories\Railway\TrainRepo;
use App\ViewData\Railway\MeetingConductorDto;
use App\ViewData\Railway\RailwayViewData;

class MeetingController extends TrainController
{
    /** @var ConductorRepo */
    protected $conductorRepo;

    /** @var TrainRepo */
    protected $trainRepo;

    /** @var ConductorSession */
    protected $meeting;

    public function __construct()
    {
        parent::__construct();

        $this->trainRepo = new TrainRepo();

        $this->conductorRepo = new ConductorRepo();
    }

    public function index()
    {
        /** @var ConductorSessionEntity $meeting */
        $meeting = (object) $this->conductorRepo->findMeetingByHeroId($this->user_id);

//        $train = $meeting->getRelation('train');

        return $this->view('railway.train.meeting.regular_bribe', [
            'meeting' => $meeting,
        ]);


    }
}
