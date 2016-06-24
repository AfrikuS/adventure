<?php

namespace App\Factories;

use App\Models\Geo\Location;
use App\Models\Geo\RoutePoint;
use App\Models\Geo\Travel\MaterialPrice;
use App\Models\Geo\TravelRoute;
use App\Models\Geo\TravelShip;
use App\Models\Work\Catalogs\WorkMaterial;
use Carbon\Carbon;

class GeoFactory
{
    public static function createLocation(string $title)
    {
        return Location::create([
            'title' => $title,
        ]);
    }

    public static function createRoute($user, string $title, int $startLocation_id)
    {
        return \DB::transaction(function () use ($user, $title, $startLocation_id) {

            $route = TravelRoute::create([
                'title' => $title,
                'user_id' => $user->id,
            ]);

            RoutePoint::create([
                'route_id' => $route->id,
                'location_id' => $startLocation_id,
                'status' => 'first',
                'number' => 1,
            ]);
            
            return $route;
        });
    }

    public static function createRoutePoint(TravelRoute $route, $location_id)
    {
        $pointsCount = $route->points->count();

        return RoutePoint::create([
            'route_id' => $route->id,
            'location_id' => $location_id,
            'status' => 'normal',
            'number' => $pointsCount + 1,
        ]);
    }

    public static function createTravelShipWithMaterials(int $location_id, Carbon $dateSending)
    {
        \DB::transaction(function () use ($location_id, $dateSending) {

            $ship = TravelShip::create([
                'destination_location_id' => $location_id,
                'date_sending' => $dateSending->toDateTimeString(),
            ]);

            $materialsCount = 5;
            $faker = \Faker\Factory::create();
            // materials for shop-ship
            $materials = WorkMaterial::get(['id', 'code'])->toArray();

            for ($i = 0; $i < $materialsCount; $i++) {
                $material = $faker->unique()->randomElement($materials);
                $price = rand(3, 6);

                MaterialPrice::create([
                    'ship_id' => $ship->id,
                    'code' => $material['code'],
                    'material_id' => $material['id'],
                    'price' => $price,
                ]);
            }
        });
    }

}
