<?php

namespace App\Domain;

use App\Models\Sea\TravelOrder;
use App\Models\Sea\TravelShip;
use App\Repositories\Generate\EntityGenerator;
use App\Repositories\SeaRepository;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Facades\Auth;

/**
 * @deprecated 
 */
class SeaActions
{
    /**
     * @deprecated
     * @see SeaRepository
     */
    public static function createOrderOnTravel(TravelShip $travel, $timeMinutes)
    {
        return SeaRepository::createOrderOnTravel($travel, $timeMinutes);
    }

    /**
     * @deprecated 
     * @see DataGeneratorController
     */
    public static function generateRandomTravel()
    {
        EntityGenerator::createSeaTravel();
    }
}
