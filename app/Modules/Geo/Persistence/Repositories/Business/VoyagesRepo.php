<?php

namespace App\Modules\Geo\Persistence\Repositories\Business;

use App\Modules\Geo\Domain\Entities\Business\TravelRoute;
use App\Modules\Geo\Domain\Entities\Business\Voyage;
use App\Modules\Geo\Domain\Services\Business\VoyageService;
use App\Modules\Geo\Persistence\Dao\Business\VoyagesDao;

class VoyagesRepo
{
    /** @var VoyagesDao */
    private $voyagesDao;

    public function __construct(VoyagesDao $voyagesDao)
    {
        $this->voyagesDao = $voyagesDao;
    }

    public function getVoyagesWithPointLocation()
    {
        $voyagesData = $this->voyagesDao->getWithTitles();
        
        return $voyagesData;
    }

    public static function getVoyages()
    {
        // with route_title, point-location_data

//        $voyagesData = $this->voyagesDao->getBy()
        
        return Voyage::select('id', 'status', 'route_id', 'point_id')
            ->with(['route' => function($query) {
                $query->select('title', 'id');
            }])
            ->with(['point' => function($query) {
                $query->select('location_id', 'status', 'number', 'route_id', 'id');
            }])
            ->get();
    }

    public function findById($id)
    {
        // with route_title, point_location
        $voyageData = $this->voyagesDao->find($id);
        
        $voyage = new Voyage($voyageData);

        return $voyage;
//        $routeData = $this->routesRepo->find($voyage->route_id);
        
        
/*        return Voyage::
                with(['route' => function($query) {
                    $query->select('title', 'id');
                }])
                ->with(['point' => function($query) {
                    $query->select('location_id', 'status', 'number', 'route_id', 'id');
                }])
                ->find($id, ['id', 'status', 'route_id', 'point_id']);*/
    }

    public function create($route_id, $point_id, $status, $ship_id)
    {
        $this->voyagesDao->create(
            $route_id,
            $ship_id,
            $point_id, 
            $status
        );   
    }

    public function updateStatus(Voyage $voyage)
    {
        $this->voyagesDao->updateStatus(
            $voyage->id, 
            $voyage->status
        );
    }

    public function update(Voyage $voyage)
    {
        $this->voyagesDao->update(
            $voyage->id,
            $voyage->point_id,
            $voyage->status
        );
    }

    public function getCountByRoute(TravelRoute $route)
    {
        return $this->voyagesDao->getCountByRoute($route->id);
    }
}
