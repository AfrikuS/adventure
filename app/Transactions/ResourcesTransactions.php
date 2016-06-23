<?php

namespace App\Transactions;

use App\Models\HeroResources;

class ResourcesTransactions
{

    public static function transferGoldBetweenUsers($userFrom, $userTo, $amount)
    {
        $from = HeroResources::find($userFrom->id, ['id', 'gold']);
        $to = HeroResources::find($userTo->id, ['id', 'gold']);

        \DB::transaction(function () use ($from, $to, $amount) {

            $from->decrement('gold', $amount);
            $to->increment('gold', $amount);
        });
    }
}
