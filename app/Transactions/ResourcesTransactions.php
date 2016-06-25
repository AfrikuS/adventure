<?php

namespace App\Transactions;

use App\Models\Hero\Resources;

class ResourcesTransactions
{

    public static function transferGoldBetweenUsers($userFrom, $userTo, $amount)
    {
        $from = Resources::find($userFrom->id, ['id', 'gold']);
        $to = Resources::find($userTo->id, ['id', 'gold']);

        \DB::transaction(function () use ($from, $to, $amount) {

            $from->decrement('gold', $amount);
            $to->increment('gold', $amount);
        });
    }
}
