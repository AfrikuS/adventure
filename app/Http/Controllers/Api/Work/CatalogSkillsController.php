<?php

namespace App\Http\Controllers\Api\Geo;

use App\Http\Controllers\Controller;
use App\Models\Geo\LocationPath;
use App\Repositories\Geo\LocationsRepository;
use stdClass;

class CatalogSkillsController extends Controller
{
    public function skills()
    {
//        $locations = LocationsRepository::getLocationsWithNexts();
//
//        $nodes = $locations->map(function ($item, $key) {
//            return [
//                'id' => $item->id,
//                'caption' => $item->title,
//            ];
//        });
//
//        $locationPaths = LocationPath::select('from_id', 'to_id')->get();
//
//        $edges = $locationPaths->map(function ($item, $key) {
//            return [
//                'source' => $item->from_id,
//                'target' => $item->to_id,
//            ];
//        });
//
//        $data = new stdClass();
//        $data->nodes = $nodes;
//        $data->edges = $edges;
//
//        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
