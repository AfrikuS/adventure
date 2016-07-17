<?php

namespace App\Repositories\Generate;

use App\Models\Geo\Trader\Ship;
use App\Models\Work\Catalogs\Material;
use App\Models\Work\Catalogs\Skill;
use App\Models\Work\Order;
use App\Models\Work\OrderMaterials;
use App\Models\Work\OrderSkill;
use App\Repositories\Work\OrderRepositoryObj;
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


    public static function createTeamWorkOrderWithMaterials()
    {
        $skill = Skill::get()->random();

        \DB::beginTransaction();
            $desc = 'order_desc';
            $order = Order::create([
                'desc' => $desc,
                'kind_work' => $skill->code,
                'price' => rand(74, 90),
                'acceptor_worker_id' => null,
                'acceptor_team_id' => null,
                'status' => 'free',
                'type' => 'team',
            ]);


            $orderRepo = new OrderRepositoryObj();
            $count = 2;
            $faker = \Faker\Factory::create();
            
            // materials for order
            $materialsCodes = Material::get(['id', 'code'])->pluck('code');
            for ($i = 0; $i < $count; $i++) {
                $materialCode = $faker->unique()->randomElement($materialsCodes->toArray());

                $material = $orderRepo->createMaterial($order->id, $materialCode, $need = 2);
            }

            // skills for order
            $count = 3;
            $skillsCodes = Skill::get(['id', 'code'])->pluck('code');
            for ($i = 0; $i < $count; $i++) {
                $skillCode = $faker->unique()->randomElement($skillsCodes->toArray());


                $skill = $orderRepo->createSkill($order, $skillCode, $need = 2);
            }
        
        \DB::commit();
    }

    public static function createShip()
    {
        Ship::create([
            'owner_id' => \Auth::id(),
//            'resource_code' => $resource,
//            'date_sending' => $dt,
        ]);
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
