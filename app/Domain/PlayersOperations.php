<?php

namespace App\Domain;

use App\Models\Macro\Resources;
use App\Models\ResourceChannel;
use Illuminate\Support\Facades\DB;

class PlayersOperations
{
    public static function addResourceChannel($atacker, $defenser)
    {
        // "money channel"
        $channel = ResourceChannel::where('from_user_id', $defenser->id)
        ->whereAnd('to_user_id',$atacker->id)
        ->whereAnd('resource', 'gold')
        ->get()->first();

        if ($channel != null) {
            $channel->tax_percent += 1;
            $channel->save();
        }
        else { // create new
            $channel = new ResourceChannel();
            $channel->to_user_id = $atacker->id;
            $channel->from_user_id = $defenser->id;
            $channel->resource = 'gold';
            $channel->tax_percent = 3;
            $channel->save();
        }
    }

    public static function exchangeResources($good, $changerUser, $offerUser)
    {
        $offerResources = Resources::find($offerUser->id);
        $changerResources = Resources::find($changerUser->id);

        DB::beginTransaction();

        try {

            $offerResources->decrement($good->resource_title, $good->resource_count);
            $offerResources->increment($good->intent_resource_title, $good->intent_resource_count);

            $changerResources->decrement($good->intent_resource_title, $good->intent_resource_count);
            $changerResources->increment($good->resource_title, $good->resource_count);

            $changerResources->save();
            $offerResources->save();
            $good->delete();

//            Resources::find($user_id)->decrement('free_people', $peopleCount);

            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollback();
        }
    }
}
