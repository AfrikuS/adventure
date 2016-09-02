<?php

namespace App\Modules\Geo\Http\Controllers\Business\Voyages;

use App\Modules\Core\Http\Controller;
use App\Http\Requests;
use App\Modules\Geo\Actions\Business\Voyages\CreateVoyageAction;
use App\Modules\Geo\Actions\Business\Voyages\ShipMoorAction;
use App\Modules\Geo\Actions\Business\Voyages\ShipSailAction;
use App\Modules\Geo\Domain\Services\Business\VoyageService;
use App\Modules\Geo\Http\Requests\Business\CreateVoyageRequest;
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

        return $this->view('geo.business.voyages.voyages', [
            'voyages' => $voyages,
        ]);
    }

    public function createVoyage(CreateVoyageRequest $request)
    {
        $ship_id  = $request->get('ship_id');
        $route_id = $request->get('route_id');


        $createVoyage = new CreateVoyageAction();
        
        $createVoyage->bindShipWithRoute($ship_id, $route_id);
        
        

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
