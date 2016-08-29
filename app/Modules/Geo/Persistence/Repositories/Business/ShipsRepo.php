<?php

namespace App\Modules\Geo\Persistence\Repositories\Business;

class ShipsRepo
{
    public function get()
    {
        $shipsData = $this->shipsDao->get();
        
        return $shipsData;
    }
}
