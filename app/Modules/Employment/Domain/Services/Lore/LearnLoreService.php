<?php

namespace App\Modules\Employment\Domain\Services\Lore;

use App\Modules\Employment\Domain\Commands\Lore\LevelUpLoreSkill;
use App\Modules\Employment\Domain\Entities\Lore;
use App\Modules\Employment\Persistence\Repositories\LoreRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;
use Illuminate\Support\Facades\Bus;

class LearnLoreService
{
    /** @var LoreRepo */
    private $loreRepo;

    /** @var OrdersRepo */
    private $ordersRepo;

    public function __construct()
    {
        $this->loreRepo = app('LoreRepo');

        $this->ordersRepo = app('OrdersRepo');
    }

    public function attemptLearnInOrderWork($order_id, $user_id)
    {
        $order = $this->ordersRepo->find($order_id);
        
        /** @var Lore $lore */
        $lore = $this->loreRepo->findBy($user_id, $order->domain_id);

        
        
        
        $index = rand(0, $lore->size - 1);

        if ($lore->isMaxValue($index)) {
            return;
        }


        if ($this->getLucky()) {


            $command = new LevelUpLoreSkill($lore->id, $index);


            Bus::dispatch($command);


            \Session::flash('message', "Навык {$index} повышен");
        }
    }

    public function attemptLearnInSchool($user_id, $lore_id)
    {
        /** @var Lore $lore */
        $lore = $this->loreRepo->find($lore_id);

        $mosaicIndex = rand(0, $lore->size - 1);

        if ($lore->isMaxValue($mosaicIndex)) {
            return;
        }


        if ($this->getLucky()) {


            $command = new LevelUpLoreSkill($lore->id, $mosaicIndex);


            Bus::dispatch($command);


            \Session::flash('message', "Навык {$mosaicIndex} повышен");
        }
    }

    private function getLucky()
    {
        return rand(1, 5) > 3;
    }
}
