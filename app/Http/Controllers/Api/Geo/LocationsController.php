<?php

namespace App\Http\Controllers\Api\Geo;

use App\Http\Controllers\Controller;
use App\Models\Geo\LocationPath;
use App\Repositories\Geo\LocationsRepository;

class LocationsController extends Controller
{
    public function locations()
    {
        $locations = LocationsRepository::getLocationsWithNexts();

        $nodes = $locations->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'caption' => $item->title,
            ];
        });

        $locationPaths = LocationPath::select('from_id', 'to_id')->get();

        $edges = $locationPaths->map(function ($item, $key) {
            return [
                'source' => $item->from_id,
                'target' => $item->to_id,
            ];
        });

//        $nodes = $locations-> toArray(); //pluck('title', 'id'); // ->toArray();

        $data = [
            ['nodes' => $nodes],
            ['edges' => $edges]
        ];


//        json_encode($array);
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
