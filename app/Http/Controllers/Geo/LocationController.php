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
//        $loc1 = Location::create(['title' => 'Главная страница']);
//        $loc1 = Location::create(['title' => 'Таверна']);
////        $loc1 = Location::find(1);
////        $loc2 = Location::find(2);
//        $loc2 = Location::create(['title' => 'Двор']);
//        $loc3 = Location::create(['title' => 'Задний двор']);
//
//        $loc1->locationsTo()->attach(3);
////        Location::addNextLocation($loc1, 2);
//
//        $locForest = Location::create(['title' => 'Лес']);
//        $loc3->locationsTo()->attach($locForest->id);

//        $loc2 = Location::create(['title' => 'Поляна']);

        $locs = Location::all();
        
        return view('geo/locations', [
            'locations' => $locs
        ]);
    }

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

        return view('geo/location_show', [
            'currLocation' => $location,
            'locationsTo' => $locationsTo,
            'locationsSelect' => $locationsSelect,
        ]);
    }

    public function bind(Request $request)
    {
        $location_id = Input::get('location_id');
        $nextLocation_id = Input::get('next_location_id');

        $location = Location::find($location_id);
        $location->locationsTo()->attach($nextLocation_id);

        return redirect('/geo/location/' . $location_id);
//        return redirect()->route('geo', [data]);
    }
}
