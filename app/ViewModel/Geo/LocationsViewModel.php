<?php

namespace App\ViewModel\Geo;

use Illuminate\Database\Eloquent\Collection;

class LocationsViewModel
{
    public static function geoListLocationsPage(Collection $locations)
    {
        $locationsRows = [];

        foreach ($locations as $location) {

            $nextLocations_ids = $location->locationsTo->map(function ($item, $key) {
                return $item->id;
            })->toArray();

            $nextLocationsTitles = $location->locationsTo->map(function ($item, $key) {
                return $item->title;
            })->toArray();

            $excludingLocations_ids = $nextLocations_ids;
            $excludingLocations_ids[] = $location->id;

            $otherLocations = $locations->reject(function ($item, $key) use ($excludingLocations_ids) {
                return in_array($item->id, $excludingLocations_ids);
            })->pluck('title', 'id');

            $columns = [
                'title' => $location->title,
                'nextLocationsTitles' => $nextLocationsTitles,
                'otherLocations' => $otherLocations,
            ];

            $locationsRows[$location->id] = $columns;
        }

        return $locationsRows;
    }

    public static function geoBuildRoutePage(Collection $locations)
    {
        $locsView = [];

        foreach ($locations as $loc) {

            $nextLocationsTitles = $loc->locationsTo->lists('title')->toArray();

            $data = [
                'title' => $loc->title,
                'next_locations_title' => $nextLocationsTitles,
            ];
            $locsView[$loc->id] = $data;
        }

        return $locsView;
    }
}