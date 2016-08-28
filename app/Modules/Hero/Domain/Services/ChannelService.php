<?php

namespace App\Modules\Hero\Domain\Services;

use App\Factories\BattleFactory;
use App\Models\Battle\ResourceChannel;
use App\Modules\Hero\Persistence\Repositories\ResourceChannelsRepo;

class ChannelService
{
    /** @var ResourceChannelsRepo */
    private $channelsRepo;

    public function __construct()
    {
        $this->channelsRepo = app('ResourceChannelsRepo');
    }

    public function addResourceChannel($teaser_id, $defenser_id)
    {
        // "money channel"
        $channel = ResourceChannel::where('from_user_id', $defenser_id)
            ->whereAnd('to_user_id', $teaser_id)
            ->whereAnd('resource', 'gold')
            ->get()->first();

        if ($channel != null) {
            $channel->tax_percent += 1;
            $channel->save();
        }
        else {
            BattleFactory::createResourceChannel($teaser_id, $defenser_id);
        }
    }

}
