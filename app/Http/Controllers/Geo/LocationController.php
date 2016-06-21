<?php

namespace App\Http\Controllers\Geo;

use App\Models\Geo\Location;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class LocationController extends Controller
{
    public function index()
    {
        $locs = Location::with('locationsTo')->get();

        $locsView = [];
        
        foreach ($locs as $loc) {

            $locationsTo = $loc->locationsTo;
            $locationsToArr = [];
            foreach ($locationsTo as $loc1) {
                $locationsToArr[] = $loc1->pivot->to_id;
            }

            $locationsSelect = Location::where('id', '<>', $loc->id)
                ->whereNotIn('id', $locationsToArr)
                ->get()->pluck('title', 'id');


            $data = [
                'title' => $loc->title,
                'next_ids' => $locationsToArr,
                'locs_select' => $locationsSelect,
            ];
            $locsView[$loc->id] = $data;
        }
        
        return $this->view('geo/locations', [
            'locations' => $locs,
            'locsView'  => $locsView,
        ]);
    }

    public function add()
    {
        $title = Input::get('title');

        Location::create([
            'title' => $title,
        ]);

        return \Redirect::route('geo_map_page');
    }

    public function bind()
    {
        $location_id = Input::get('location_id');
        $nextLocation_id = Input::get('next_location_id');

        $location = Location::find($location_id);
        $location->locationsTo()->attach($nextLocation_id);

        return \Redirect::route('geo_map_page');
    }


    /** @deprecated  node */
    public function show(Request $request, $location_id)
    {
        $location = Location::find($location_id);

        $locationsTo = $location->locationsTo;
        $locationsToArr = [];
        foreach ($locationsTo as $loc) {
            $locationsToArr[] = $loc->pivot->to_id;
        }
        $locationsSelect = Location::where('id', '<>', $location_id)
            ->whereNotIn('id', $locationsToArr)
            ->get()->pluck('title', 'id');

        return $this->view('geo.location_show', [
            'currLocation' => $location,
            'locationsTo' => $locationsTo,
            'locationsSelect' => $locationsSelect,
        ]);
    }
}
