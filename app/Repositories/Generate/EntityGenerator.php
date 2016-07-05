<?php

namespace App\Repositories\Generate;

use App\Models\Geo\Trader\Ship;
use App\Models\Sea\TravelShip;
use App\Models\Work\Catalogs\Material;
use App\Models\Work\Catalogs\Skill;
use App\Models\Work\Order;
use App\Models\Work\OrderMaterials;
use App\Models\Work\Team\TeamOrder;
use App\Models\Work\Team\TeamOrderMaterial;
use App\Models\Work\Team\TeamOrderSkill;
use App\Models\Work\UserMaterial;
use App\Repositories\Work\Team\TeamOrderMaterialRepository;
use App\Repositories\Work\Team\TeamOrderRepository;
use App\Repositories\Work\Team\TeamOrderSkillRepository;
use Carbon\Carbon;
use Faker\Factory;

class EntityGenerator
{
    public static function createSeaTravel()
    {
        $timeMinutes = rand(3, 7);
        $resources = ['whater', 'oil', 'gold', 'pillow'];
        $resource = $resources[rand(0, 3)];
        $faker = Factory::create();
        $destination = $faker->city;
        $dt = Carbon::create()->addMinutes($timeMinutes)->toDateTimeString();

        TravelShip::create([
            'destination' => $destination . '_' . $timeMinutes,
            'resource_code' => $resource,
            'date_sending' => $dt,
        ]);
    }

    public static function deleteSeaTravel($id)
    {
        TravelShip::destroy($id);
    }

    public static function createWorkOrderWithMaterials()
    {
        $skill = Skill::get()->random();

        \DB::transaction(function () use ($skill) {
            $desc = 'order_desc';
            $order = Order::create([
                'desc' => $desc,
                'kind_work_title' => $skill->code,
                'price' => rand(74, 90),
                'acceptor_user_id' => null,
                'status' => 'free' // accept -> user_id
            ]);

            static::searchRandomMaterials(2, $order);
        });
    }

    public static function createTeamWorkOrderWithMaterials()
    {
        $skill = Skill::get()->random();

        \DB::transaction(function () use ($skill) {
            $desc = 'order_desc';
            $order = TeamOrder::create([
                'desc' => $desc,
                'kind_work' => $skill->code,
                'price' => rand(74, 90),
                'acceptor_team_id' => null,
                'status' => 'free' // accept -> user_id
            ]);


            $count = 2;
            $faker = \Faker\Factory::create();
            
            // materials for order
            $materialsCodes = Material::get(['id', 'code'])->pluck('code');
            for ($i = 0; $i < $count; $i++) {
                $materialCode = $faker->unique()->randomElement($materialsCodes->toArray());
                TeamOrderMaterial::create([
                    'teamorder_id' => $order->id,
                    'code' => $materialCode,
                    'need' => 2,
                    'stock' => 0,
                ]);
            }

            // skills for order
            $count = 3;
            $skillsCodes = Skill::get(['id', 'code'])->pluck('code');
            for ($i = 0; $i < $count; $i++) {
                $skillCode = $faker->unique()->randomElement($skillsCodes->toArray());
                TeamOrderSkill::create([
                    'teamorder_id' => $order->id,
                    'code' => $skillCode,
                    'need_times' => 2,
                    'stock_times' => 0,
                ]);
            }
        });
    }

    public static function createShip()
    {
        Ship::create([
            'owner_id' => \Auth::id(),
//            'resource_code' => $resource,
//            'date_sending' => $dt,
        ]);
    }

    private static function searchRandomMaterials($count, Order $order)
    {
        $faker = \Faker\Factory::create();
        $materialsCodes = Material::get(['id', 'code'])->pluck('code');

        for ($i = 0; $i < $count; $i++) { // wtf todo
            $materialCode = $faker->unique()->randomElement($materialsCodes->toArray());
            $material = OrderMaterials::create([
                'order_id' => $order->id,
                'code' => $materialCode,
                'need' => 2,
                'stock' => 0,
            ]);
        }
    }
    

    /** @deprecated */
    public static function createUserMaterials($user)
    {
        $faker = \Faker\Factory::create();
        $materialsCodes = Material::pluck('code');

        //         $faker->valid($evenValidator)->randomElement(1, 3, 5, 7, 9);

        $materialCode = $faker->unique()->randomElement($materialsCodes->toArray());
        WorkerMaterial::select('id')->updateOrCreate(
            ['code' => $materialCode, 'user_id' => $user->id],
            ['value' => rand(79, 157), 'user_id' => $user->id]
        );
    }
}
