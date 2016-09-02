<?php

namespace App\Modules\Oil\Actions\Equipment;

use App\Modules\Hero\Domain\Entities\Hero;
use App\Modules\Hero\Persistence\Repositories\HeroRepo;
use App\Modules\Oil\Domain\Entities\OilDistiller;
use App\Modules\Oil\Domain\Lib\OilDistillProcessor;
use App\Modules\Oil\Domain\Lib\OilPumpExtractor;
use App\Modules\Oil\Domain\Services\Base\EquipmentService;
use App\Modules\Oil\Persistence\Repositories\OilDistillerRepo;
use Finite\Exception\StateException;

class OilDistillerProcessAction
{
    /** @var OilDistillerRepo */
    private $distillerRepo;

    /** @var HeroRepo */
    private $heroRepo;

    public function __construct()
    {
        $this->distillerRepo = app('OilDistillerRepo');
        $this->heroRepo = app('HeroRepo');
    }

    public function process($hero_id)
    {
        /** @var OilDistiller $distiller */
        $distiller = $this->distillerRepo->findBy($hero_id);

        /** @var Hero $hero */
        $hero = $this->heroRepo->getHero($hero_id);
        
//        $this->validateAction($distiller);

        $equipmentService = new EquipmentService();

        $equipmentService->processDistill($distiller, $hero);


    }

    private function validateAction(OilDistiller $distiller)
    {
    }
}
