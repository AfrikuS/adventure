<?php

namespace App\Factories;

use App\Models\Npc\NpcDeal;

class NpcFactory
{
    public static function createNpcDeal($hero)
    {
        NpcDeal::create([
            'hero_id' => $hero->id,
            'npc_char' => 'Паратов С.С.', 
            'task' => 'Пойти туда, принести то', 
            'reward' => 'Пароход Ласточка', 
            'offer_status' => 'created', 
            'offer_ending' => null, 
            'deal_status' => 'no_status', 
            'deal_ending' => null,
        ]);
    }
}
