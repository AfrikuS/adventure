<?php

namespace App\Modules\Npc\Actions;

class GenerateNpcOffer
{
    public function generate($user_id)
    {
        $offers = app('OffersRepo');

        $character = 'Паратов С.С.';
        $task = 'Пойти туда, принести то';
        $reward = 'Пароход Ласточка';
        
        
        $offers->create(
            $user_id,
            $character,
            $task,
            $reward
        );
    }
}
