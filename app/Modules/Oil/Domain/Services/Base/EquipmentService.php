<?php

namespace App\Modules\Oil\Domain\Services\Base;

use App\Modules\Hero\Domain\Entities\Hero;
use App\Modules\Hero\Persistence\Repositories\HeroRepo;
use App\Modules\Oil\Domain\Entities\OilDistiller;
use App\Modules\Oil\Domain\Entities\OilPump;
use App\Modules\Oil\Domain\Lib\OilDistillProcessor;
use App\Modules\Oil\Persistence\Repositories\OilDistillerRepo;
use App\Modules\Oil\Persistence\Repositories\OilPumpRepo;

class EquipmentService
{
    /** @var  OilDistillerRepo */
    private $distillerRepo;

    /** @var  OilPumpRepo */
    private $pumpRepo;

    /** @var HeroRepo */
    private $heroRepo;

    public function __construct()
    {
        $this->pumpRepo = app('OilPumpRepo');
        $this->distillerRepo = app('OilDistillerRepo');
        $this->heroRepo = app('HeroRepo');
    }

    public function upgradeOilPump(OilPump $oilPump)
    {
        $oilPump->upgradeLevel();


        $this->pumpRepo->updateLevel($oilPump);
    }

    public function upgradeOilDistiller(OilDistiller $distiller)
    {
        $distiller->upgradeLevel();


        $this->distillerRepo->updateLevel($distiller);
    }

    public function processDistill(OilDistiller $distiller, Hero $hero)
    {
        $distillProcessor = new OilDistillProcessor();

        $oilDistillAmount = $distillProcessor->process($distiller);



        $hero->incrementGold($oilDistillAmount);

        $this->heroRepo->updateResources($hero);

    }
}
