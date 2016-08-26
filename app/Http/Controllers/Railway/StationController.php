<?php

namespace App\Http\Controllers\Railway;

use App\Models\Npc\Character;
use App\Models\Npc\ConductorSession;
use App\Models\Railway\TransitTrain;
use App\Repositories\Railway\Station\ConductorRepo;
use App\Repositories\Railway\TrainsRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class StationController extends RailwayController
{
    /** @var TrainsRepo */
    protected $trainsRepo;

    public function __construct(TrainsRepo $trainsRepo)
    {
        parent::__construct();
        $this->trainsRepo = $trainsRepo;
    }

    public function index()
    {
        $conductorRepo = new ConductorRepo();


        $meeting = $conductorRepo->findMeetingByHeroId($this->user_id);

        if ($meeting == null) {

            return $this->trains();
        }

        return \Redirect::route('railway_train_page');

    }

    public function goToTrainConductor()
    {
        $data = Input::all();
        $train_id = $data['train_id'];

        $train = TransitTrain::find($train_id);
        
        if (null == $train) {
            \Session::flash('message', 'trin is not exist');
            return \Redirect::route('railway_trains_page');
        }


        $conductorRepo = new ConductorRepo();
        
        $conductorRepo->createMeetingWithHero($this->user_id, $train->conductor_id, $train->id, $train->end_time);
        
        

        return \Redirect::route('railway_train_page');
    }
    
    

    public function generateTrain()
    {
        $start = Carbon::create()->addSeconds(4)->toDateTimeString();
        $end = Carbon::create()->addMinutes(823)->toDateTimeString();

        $conductorsIds = Character::get()->pluck('id')->toArray();

        $faker = \Faker\Factory::create();


        $conductorId = $faker->randomElement($conductorsIds);

        $this->trainsRepo->createTrain($conductorId, $start, $end);


        return \Redirect::route('railway_trains_page');
    }

    public function deleteOlds()
    {
        $oldTrainsIds = $this->trainsRepo->getOldTrains()->pluck('id')->toArray();

        TransitTrain::destroy($oldTrainsIds);
//        $oldTrains->each(function ($item, $key) {
//            $item->delete();
//        });

        return \Redirect::route('railway_trains_page');
    }

    private function trains ()
    {
        $nearTrains = $this->trainsRepo->getNearTrains();

        $activeTrains = $this->trainsRepo->getActiveTrains();


        return $this->view('railway.station', [
            'nearTrains' => $nearTrains,
            'activeTrains' => $activeTrains,
        ]);
    }


}
