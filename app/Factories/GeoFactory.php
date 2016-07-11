<?php

namespace App\Factories;

use App\Models\Geo\LiveVoyage;
use App\Models\Geo\Location;
use App\Models\Geo\RoutePoint;
use App\Models\Geo\Trader\Ship;
use App\Models\Geo\Travel\MaterialPrice;
use App\Models\Geo\Travel\TempShop;
use App\Models\Geo\TravelRoute;
use App\Models\Geo\TravelShip;
use App\Models\Geo\Voyage;
use App\Models\Work\Catalogs\Material;
use Carbon\Carbon;

class GeoFactory
{

    public static function createRoute(int $trader_id, string $routeTitle, int $startLocation_id)
    {
        $route = TravelRoute::create([
            'title' => $routeTitle,
            'user_id' => $trader_id,
            'status' => 'drafting',
        ]);

        RoutePoint::create([
            'route_id' => $route->id,
            'location_id' => $startLocation_id,
            'status' => 'first',
            'number' => 1,
        ]);
 
        return $route;
    }


    public static function generateTempShopWithMaterials(Carbon $dateEnding)
    {
        \DB::transaction(function () use ($dateEnding) {

            $shop = TempShop::create([
                'date_ending' => $dateEnding->toDateTimeString(),
            ]);

            $materialsCount = 5;
            $faker = \Faker\Factory::create();
            // materials for shop-ship
            $materials = Material::get(['id', 'code'])->toArray();

            for ($i = 0; $i < $materialsCount; $i++) {
                $material = $faker->unique()->randomElement($materials);
                $price = rand(3, 6);

                MaterialPrice::create([
                    'shop_id' => $shop->id,
                    'code' => $material['code'],
                    'material_id' => $material['id'],
                    'price' => $price,
                ]);
            }
        });
    }

    public static function createLiveVoyage($location_id, $user_id)
    {
        return LiveVoyage::create([
            'location_id' => $location_id,
            'traveler_id' => $user_id,
            'status' => 'ready_to_sail',
        ]);
    }

    public static function createVoyage(TravelRoute $route, Ship $ship)
    {
        $startPoint = $route->points->first();

        return Voyage::create([
            'route_id' => $route->id,
            'point_id' => $startPoint->id,
            'status' => 'ready_start',
            'ship_id' => $ship->id,
        ]);
    }
}
