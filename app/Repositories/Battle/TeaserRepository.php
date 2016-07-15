<?php

namespace App\Repositories\Battle;

use App\Factories\BattleFactory;
use App\Models\Battle\ResourceChannel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TeaserRepository
{
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

    public function getAttackedIdsByUserId($user_id)
    {
        $attackedUsersIds = \DB::table('event_attacks')
            ->select('defense_user_id')
            ->where('attack_user_id', $user_id)
            ->where(\DB::raw('TIMESTAMPDIFF(SECOND, now(), event_attacks.attack_moment)'), '>', 0)
//            ->addSelect(DB::raw('TIMESTAMPDIFF(SECOND, now(), event_attacks.attack_moment) AS duration_seconds'))
//            ->havingRaw('duration_seconds > 0')
            ->get();

        return $attackedUsersIds;
    }

    public function insertAttackEvent($atacker_id, $defenser_id, Carbon $moment)
    {
        $attackExist = \DB::table('event_attacks')
            ->whereExists(function($query) use($atacker_id, $defenser_id)
            {

                $query->select(DB::raw(1))
                    ->from('event_attacks')
                    ->where('defense_user_id', $defenser_id)
                    ->where('attack_user_id', $atacker_id);
            })
            ->get();

        if ($attackExist) {
            DB::table('event_attacks')
                ->where('attack_user_id', $atacker_id)
                ->where('defense_user_id', $defenser_id)
                ->update(['attack_moment' => $moment->toDateTimeString()]);
        }
        else {
            DB::table('event_attacks')->insert([
                'attack_user_id' => $atacker_id,
                'defense_user_id' => $defenser_id,
                'defenser_user_name' => $defenser_id . ' _ name',
                'attack_moment' => $moment->toDateTimeString(),
            ]);
        }
    }



}
