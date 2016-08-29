<?php

namespace App\Modules\Geo\Domain\Services\Business;

use App\Entities\Geo\VoyageStateMachine;
use App\Modules\Geo\Domain\Entities\Business\TravelRoute;
use App\Modules\Geo\Domain\Entities\Business\Voyage;
use App\Modules\Geo\Persistence\Repositories\Business\ShipsRepo;
use App\Modules\Geo\Persistence\Repositories\Business\VoyagesRepo;
use App\Modules\Geo\Persistence\Repositories\LocationsRepo;
use App\Modules\Geo\Persistence\Repositories\TravelRoutesRepo;
use App\Repositories\Geo\TravelRoutesRepository;

class VoyageService
{
    /** @var VoyagesRepo */
    private $voyagesRepo;

    /** @var TravelRoutesRepo */
    private $routesRepo;

    /** @var ShipsRepo */
    private $shipsRepo;

    /** @var LocationsRepo */
    private $locationsRepo;

    public function __construct()
    {
        $this->voyagesRepo = app('VoyagesRepo');
        $this->routesRepo = app('TravelRoutesRepo');
        $this->shipsRepo = app('ShipsRepo');
        $this->locationsRepo = app('LocationsRepo');
    }

    public function create(int $route_id, int $ship_id)
    {
        /** @var TravelRoute $route */
        $route = $this->routesRepo->find($route_id);

        $ship = $this->shipsRepo->find($ship_id);



        \DB::beginTransaction();
        try {

            $ship->setOnRoute($route);

            $this->shipsRepo->update($ship);


            $startPoint = $route->firstPoint();

            $this->voyagesRepo->create(
                $route->id,
                $startPoint->id,
                Voyage::STATUS_READY,
                $ship->id
            );

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

    }

    public function shipMoor($voyage_id)
    {
        /** @var Voyage $voyage */
        $voyage = $this->voyagesRepo->findById($voyage_id);

//        $route = $this->routesRepo->findById($voyage->route_id);
        
        
//        $voyageSM = new VoyageStateMachine($voyage);

        $voyage->moor();

        $this->voyagesRepo->updateStatus($voyage);

        // define location, compare with finish-location

        $this->checkFinishVoyage($voyage);




    }

    public function inSail($voyage_id)
    {
        /** @var Voyage $voyage */
        $voyage = $this->voyagesRepo->findById($voyage_id);


        $voyage->inSail();


        $this->voyagesRepo->updateStatus($voyage);
    }

    private function checkFinishVoyage(Voyage $voyage)
    {
//        $currentLocation = $this->locationsRepo->find($voyage->point_id);

        $route = $this->routesRepo->find($voyage->route_id);
        $lastPoint = $route->lastPoint();

        if ($lastPoint->id === $voyage->point_id) {

            $voyage->finish();
            $this->voyagesRepo->updateStatus($voyage);
        }
        else {

            $this->changeLocation($voyage);
        }
    }

    private function changeLocation(Voyage $voyage)
    {
        /** @var TravelRoute $route */
        $route = $this->routesRepo->find($voyage->route_id);

        $currPoint_id = $voyage->point_id;
        
        $nextPoint = $route->getNextPointBy($currPoint_id);


        
        $voyage->point_id = $nextPoint->id;

        $this->voyagesRepo->update($voyage);
    }
}
