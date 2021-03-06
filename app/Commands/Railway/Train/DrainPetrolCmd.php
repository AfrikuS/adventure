<?php

namespace App\Commands\Railway\Train;

use App\Entities\Hero\HeroEntity;
use App\Repositories\HeroRepositoryObj;

class DrainPetrolCmd
{
    /** @var  HeroRepositoryObj */
    protected $heroRepo;

    public function __construct(HeroRepositoryObj $heroRepo)
    {
        $this->heroRepo = $heroRepo;
    }

    public function drainPetrol($hero_id, $amount, $price)
    {
        /** @var HeroEntity $hero */
        $hero = $this->heroRepo->findById($hero_id);

        $goldSum = $amount * $price;


        \DB::beginTransaction();
        try {

            $hero->incrWater($amount);

            $hero->decrGold($goldSum);

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }
}
