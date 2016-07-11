<?php

namespace App\ViewData\Geo;

use Illuminate\Database\Eloquent\Collection;
use stdClass;

class LocationsViewData
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
        $rows = [];

        foreach ($locations as $location) {
            $nextLocationsTitles = $location->locationsTo->lists('title')->toArray();

            $data = [
                'title' => $location->title,
                'next_locations_title' => $nextLocationsTitles,
            ];

            $rows[$location->id] = $data;
        }

        return $rows;
    }
}