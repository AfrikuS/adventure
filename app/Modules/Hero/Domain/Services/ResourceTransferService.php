<?php

namespace App\Modules\Hero\Domain\Services;

use App\Modules\Hero\Domain\Commands\Resources\DecrementGold;
use App\Modules\Hero\Domain\Commands\Resources\IncrementGold;
use Illuminate\Support\Facades\Bus;

class ResourceTransferService
{
    public function transferGold($fromHero_id, $toHero_id, int $amount)
    {
        $incrementGold = new IncrementGold($toHero_id, $amount);
        $decrementGold = new DecrementGold($fromHero_id, $amount);
        
        Bus::dispatch($incrementGold);
        Bus::dispatch($decrementGold);
    }
}
