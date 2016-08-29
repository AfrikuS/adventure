<?php

namespace App\Factories;

use App\Models\Macro\ExchangeGood;

class MarketFactory
{
    public static function createExchangeOffer($initiator, $resCode, $resAmount, $intentResCode, $intentResAmount)
    {
        ExchangeGood::create([
            'resource_title' => $resCode,
            'resource_count' => $resAmount,
            'intent_resource_title' => $intentResCode,
            'intent_resource_count' => $intentResAmount,
            'user_id' => $initiator->id,
        ]);
    }
}
