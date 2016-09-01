<?php

namespace App\Modules\Hero\Actions;

use App\Modules\Hero\Domain\Entities\Buildings;
use App\Modules\Hero\Persistence\Repositories\BuildingsRepo;

class UpBuildingLevelAction
{
    /** @var BuildingsRepo */
    private $buildingsRepo;

    public function __construct(BuildingsRepo $buildingsRepo)
    {
        $this->buildingsRepo = $buildingsRepo;
    }

    public function upBuildingLevel($hero_id, $code)
    {
        /** @var Buildings */
        $heroBuildings = $this->buildingsRepo->getByHero($hero_id);

        $this->validateAction($heroBuildings, $code);

        switch ($code)
        {
            case Buildings::GATES:

                $heroBuildings->increment('gates_level', 1);
                break;
            case Buildings::FENCE:

                $heroBuildings->increment('fence_level', 1);
                break;

            default:
                break;
        }
    }
}
