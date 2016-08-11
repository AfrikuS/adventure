<?php

namespace App\Repositories;

use App\Entities\Hero\HeroEntity;
use App\Exceptions\NotEnoughResourceException;
use App\Models\Core\Buildings;
use App\Models\Core\Hero;
use App\Models\Core\Thing;
use App\Entities\Trade\ThingStateMachine;

class HeroRepositoryObj
{
    /**
     * @return ThingStateMachine|null
     */
    public function findThingById($id): ThingStateMachine
    {
        $thing = Thing::find($id, ['id', 'title', 'status', 'owner_id']);
        
        return new ThingStateMachine($thing);
    }
    
    public function findById($id)
    {
        $hero = Hero::find($id, ['id', 'gold', 'oil', 'water']);
        
        return new HeroEntity($hero);
    }

    public function decrementGold(Hero $hero, $amount)
    {
        if ($amount > $hero->gold) {

            throw new NotEnoughResourceException();
        }

        $hero->decrement('gold', $amount);
    }

    public function incrementGold(Hero $hero, $amount)
    {
        $hero->increment('gold', $amount);
    }

    public function createHero($user_id)
    {
        // default data for hero
        return Hero::create([
            'id' => $user_id,
            'gold'  => 500,
            'oil'   => 600,
            'water' => 700,
        ]);
    }

    public function createBuildings($hero_id)
    {
        return Buildings::create([
            'id' => $hero_id,
            'gates_level' => 34,
            'fence_level' => 35,
            'door_house_level' => 36,
            'door_ambar_level' => 37,
            'door_resource_warehause_level' => 38,
        ]);
    }

    public function findHeroWithBuildings($id): Hero
    {
        return Hero::with('buildings')->find($id);
    }

}
