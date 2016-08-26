<?php

namespace App\Commands\Macro;

use App\Models\Macro\ExchangeGood;
use App\Models\Macro\Resources;

/** @deprecated  */ // todo redo
class ExchangeResourcesCommand
{
    public function exchange(ExchangeGood $good, $changerUser, $offerUser)
    {
        $offerResources = Resources::find($offerUser->id);
        $changerResources = Resources::find($changerUser->id);

        \DB::transaction(function () use ($offerResources, $changerResources, $good) {

            $offerResources->decrement($good->resource_title, $good->resource_count);
            $offerResources->increment($good->intent_resource_title, $good->intent_resource_count);

            $changerResources->decrement($good->intent_resource_title, $good->intent_resource_count);
            $changerResources->increment($good->resource_title, $good->resource_count);

            $changerResources->save();
            $offerResources->save();
            $good->delete();
        });


    }
}
