<?php

namespace App\Modules\Geo\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Modules\Geo\Actions\Business\Voyages\ShipMoorAction;
use App\Modules\Geo\Actions\Business\Voyages\ShipSailAction;
use App\Modules\Geo\Domain\Services\Business\VoyageService;
use App\Modules\Geo\Persistence\Repositories\Business\VoyagesRepo;
use Illuminate\Support\Facades\Input;

class VoyagesController extends Controller
{
    /** @var VoyagesRepo */
    private $voyagesRepo;

    public function __construct()
    {
        parent::__construct();

        $this->voyagesRepo = app('VoyagesRepo');
    }

    public function index()
    {
        /** @var VoyagesRepo $voyagesRepo */
        $voyagesRepo = app('VoyagesRepo');

        $voyages = $voyagesRepo->getVoyagesWithPointLocation();

        return $this->view('geo.business.voyages', [
            'voyages' => $voyages,
        ]);
    }

    public function createVoyage()
    {
        $data = Input::all();
        if ((! isset($data['route_id'])) || (! $data['ship_id'])) {

            \Session::flash('message', 'not null');
            return \Redirect::route('geo_sea_freights_page');
        }

        $route_id = $data['route_id'];
        $ship_id = $data['ship_id'];


        $voyageService = new VoyageService();

        $voyageService->create($route_id, $ship_id);

        

        return \Redirect::route('geo_sea_freights_page');
    }

    public function sail()
    {
        $data = Input::all();
        $voyage_id = $data['voyage_id'];


        $shipMoorAction = new ShipSailAction();

        $shipMoorAction->toSail($voyage_id);


        return \Redirect::back();
    }

    public function moor() // причалить
    {
        $data = Input::all();
        $voyage_id = $data['voyage_id'];

        
        $shipMoorAction = new ShipMoorAction();

        $shipMoorAction->moor($voyage_id);


        return \Redirect::back();
    }
}
