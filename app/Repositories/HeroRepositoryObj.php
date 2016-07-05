<?php

namespace App\Repositories;

use App\Exceptions\DefecitHeroResException;
use App\Models\Core\Hero;
use App\Models\Core\Thing;
use App\StateMachines\Trade\ThingStateMachine;

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
        return Hero::find($id, ['id', 'gold', 'oil', 'water']);
    }

    public function decrementGold(Hero $hero, $amount)
    {
        if ($amount > $hero->gold) {

            throw new DefecitHeroResException();
        }

        $hero->decrement('gold', $amount);
    }

    public function incrementGold(Hero $hero, $amount)
    {
        $hero->increment('gold', $amount);
    }

}
