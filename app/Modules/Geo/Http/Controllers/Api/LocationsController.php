<?php

namespace App\Modules\Geo\Http\Controllers\Api;

use App\Modules\Core\Http\Controller;
use App\Models\Geo\LocationPath;
use App\Modules\Geo\Persistence\Repositories\LocationsRepo;
use stdClass;

class LocationsController extends Controller
{
    /** @var LocationsRepo */
    private $locationsRepo;

    public function __construct(LocationsRepo $locationsRepo)
    {
        $this->locationsRepo = $locationsRepo;

        parent::__construct();
    }

    public function locations()
    {
        $locationsColl = $this->locationsRepo->getLocationsWithNexts();

        $nodes = array_map(function ($item, $key) {
            return [
                'id' => $item->id,
                'caption' => $item->title,
            ];

        }, $locationsColl->locations);

        $locationPaths = LocationPath::select('from_id', 'to_id')->get();

        $edges = $locationPaths->map(function ($item, $key) {
            return [
                'source' => $item->from_id,
                'target' => $item->to_id,
            ];
        });
        
        $data = new stdClass();
        $data->nodes = $nodes;
        $data->edges = $edges;

        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
