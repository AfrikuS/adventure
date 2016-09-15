<?php

namespace App\Modules\Geo\Persistence\Repositories;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Geo\Domain\Entities\Business\RoutePoint;
use App\Modules\Geo\Domain\Entities\Business\TravelRoute;
use App\Modules\Geo\Persistence\Dao\TravelRoutesDao;
use App\Modules\Geo\Persistence\Repositories\TravelRoute\RoutePointsRepo;

class TravelRoutesRepo
{
    /** @var TravelRoutesDao */
    private $travelRoutes;

    /** @var RoutePointsRepo */
    private $routePointsRepo;

    public function __construct(TravelRoutesDao $travelRoutes, RoutePointsRepo $routePointsRepo)
    {
        $this->travelRoutes = $travelRoutes;
        $this->routePointsRepo = $routePointsRepo;
    }

    /** @deprecated  */
    public function findTravelWithPointsById($id)
    {
/*        $route = TravelRoute::
            select('id', 'status', 'user_id')
                ->with(['points' => function ($query) {
                    $query->select('id', 'location_id', 'status', 'number', 'route_id');
                }])
                ->find($id);*/

        $routeData = $this->travelRoutes->find($id);

        $route = new TravelRoute($routeData);

        $nodes = $this->routePointsRepo->getByRouteWithLocations($id); // RoutePoint


        $route->setPoints($nodes);

        
        return $route;


/*        return TravelRoute::
        select('id', 'status', 'user_id')
            ->with(['points' => function($query) {
                $query->select('id', 'location_id', 'status', 'number', 'route_id');
            }])
            ->find($id);*/


//        return new TravelRouteEntity($route);
    }

    public function find($id)
    {
        $route = EntityStore::get(TravelRoute::class, $id);

        if (null != $route) {

            return $route;
        }

        $routeData = $this->travelRoutes->find($id);
        
        $route = new TravelRoute($routeData);



        $nodes = $this->routePointsRepo->getByRouteWithLocations($id); // RoutePoint
        
        $route->setPoints($nodes);
        
        
        
        EntityStore::add($route, $route->id);

        return $route;
    }

    public function create(int $trader_id, string $routeTitle)
    {
        $route_id = $this->travelRoutes->create(
            $trader_id, 
            $routeTitle, 
            TravelRoute::STATUS_DRAFT
        );

        return $route_id;
    }

    public function get()
    {
        $routes = $this->travelRoutes->get();
        
        return $routes;
    }

    public function findById($id)
    {
        return TravelRoute::with(['points' => function($query) {
            $query->select('location_id', 'status', 'number', 'route_id', 'id')
                ->with(['location' => function($query) {
                    $query->select('id', 'title');
                }]);
        }])
            ->select('id', 'title')
            ->find($id);
    }

    public function update(TravelRoute $route)
    {
        $this->travelRoutes->update(
            $route->id,
            $route->status
        );
    }

    public function getCommittedRoutes()
    {
        $routes = $this->travelRoutes->getByStatus(TravelRoute::STATUS_COMMITTED);

        return $routes;
    }

    public function getDraftRoutes()
    {
        $routes = $this->travelRoutes->getByStatus(TravelRoute::STATUS_DRAFT);

        return $routes;
    }
}
