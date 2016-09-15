<?php

namespace App\Modules\Geo\Actions\Business\Voyages;

use App\Modules\Geo\Domain\Entities\Business\Ship;
use App\Modules\Geo\Domain\Entities\Business\TravelRoute;
use App\Modules\Geo\Domain\Services\Business\VoyageService;
use App\Modules\Geo\Persistence\Repositories\Business\ShipsRepo;
use App\Modules\Geo\Persistence\Repositories\TravelRoutesRepo;
use Finite\Exception\StateException;

class CreateVoyageAction
{
    /** @var TravelRoutesRepo */
    private $routesRepo;

    /** @var ShipsRepo */
    private $shipsRepo;

    public function __construct()
    {
        $this->routesRepo = app('TravelRoutesRepo');
        $this->shipsRepo = app('ShipsRepo');
    }

    public function bindShipWithRoute($ship_id, $route_id)
    {
        /** @var TravelRoute $route */
        $route = $this->routesRepo->find($route_id);
        /** @var Ship $ship */
        $ship = $this->shipsRepo->find($ship_id);


        $this->validateAction($route, $ship);


        $voyageService = new VoyageService();


        \DB::beginTransaction();
        try {

            $voyageService->create($route_id, $ship_id);

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }

    private function validateAction(TravelRoute $route, Ship $ship)
    {
        if (! $route->isCommitted()) {

            throw new StateException('Route is not committed');
        }

        if ($ship->isFreighted()) {

            throw new StateException('Ship is freighted yet');
        }
    }
}
