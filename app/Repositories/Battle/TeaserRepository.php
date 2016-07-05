<?php

namespace App\Repositories\Battle;

use App\Factories\BattleFactory;
use App\Models\Battle\ResourceChannel;

class TeaserRepository
{
    public function addResourceChannel($teaser, $defenser)
    {
        // "money channel"
        $channel = ResourceChannel::where('from_user_id', $defenser->id)
            ->whereAnd('to_user_id', $teaser->id)
            ->whereAnd('resource', 'gold')
            ->get()->first();

        if ($channel != null) {
            $channel->tax_percent += 1;
            $channel->save();
        }
        else {
            BattleFactory::createResourceChannel($teaser, $defenser);
        }
    }


}
