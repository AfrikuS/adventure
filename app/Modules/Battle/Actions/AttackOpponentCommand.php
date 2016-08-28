<?php

namespace App\Modules\Battle\Actions;

use App\Models\Auth\User;
use App\Modules\Battle\Domain\Services\AttackService;
use App\Modules\Hero\Domain\Services\ChannelService;
use App\Repositories\AttackRepository;
use App\Repositories\Battle\TeaserRepository;
use Carbon\Carbon;

class AttackOpponentCommand
{
    public function __construct()
    {
    }

    public function attack($atacker_id, $defenser_id)
    {
        $attackService = new AttackService();
        $channelService = new ChannelService();



        \DB::beginTransaction();
        try {

            $attackService->addAttackEvent($atacker_id, $defenser_id);


            $channelService->addResourceChannel($atacker_id, $defenser_id);
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }
}
