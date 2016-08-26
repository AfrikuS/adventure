<?php

namespace App\Commands\Hero;

use App\Models\Core\Buildings;

class UpBuildingLevelCmd
{
    public function upBuildingLevel($hero_id, $code)
    {
        /** @var Buildings */
        $buildings = Buildings::find($hero_id);


        switch ($code)
        {
            case 'gates':

                $buildings->increment('gates_level', 1);
                break;
            case 'fence':

                $buildings->increment('fence_level', 1);
                break;

            default:
                break;
        }
    }
}
