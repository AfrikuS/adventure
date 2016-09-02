<?php

namespace App\Modules\Oil\Actions\Equipment;

use App\Modules\Hero\Domain\Entities\Hero;
use App\Modules\Hero\Persistence\Repositories\HeroRepo;
use App\Modules\Oil\Domain\Entities\OilPump;
use App\Modules\Oil\Domain\Lib\OilPumpExtractor;
use App\Modules\Oil\Persistence\Repositories\OilPumpRepo;
use Finite\Exception\StateException;

class OilPumpProcessAction
{
    /** @var OilPumpRepo */
    private $oilPumpRepo;

    /** @var HeroRepo */
    private $heroRepo;

    public function __construct()
    {
        $this->oilPumpRepo = app('OilPumpRepo');
        $this->heroRepo = app('HeroRepo');
    }

    public function process($hero_id)
    {
        /** @var OilPump $oilPump */
        $oilPump = $this->oilPumpRepo->findBy($hero_id);

        /** @var Hero $hero */
        $hero = $this->heroRepo->getHero($hero_id);
        
//        $this->validateAction($oilPump);

        $oilPumpExtractor = new OilPumpExtractor();
        
        $oilExtractionAmount = $oilPumpExtractor->process($oilPump);

        
        
        $hero->incrementOil($oilExtractionAmount);

        $this->heroRepo->updateResources($hero);
    }

    private function validateAction(OilPump $oilPump)
    {
        // current user-status ?
        if ($oilPump->isFullUpgrade()) {

            throw new StateException('Нефтяной насос прокачан по максимуму');
        }
    }
}
