<?php

namespace App\Modules\Geo\Actions\Business\Voyages;

use App\Modules\Geo\Domain\Entities\Business\Voyage;
use App\Modules\Geo\Domain\Services\Business\VoyageService;
use App\Modules\Geo\Persistence\Repositories\Business\VoyagesRepo;
use Finite\Exception\StateException;

class ShipMoorAction
{
    /** @var VoyagesRepo */
    private $voyagesRepo;

    public function __construct()
    {
        $this->voyagesRepo = app('VoyagesRepo');
    }

    public function moor($voyage_id)
    {
        /** @var Voyage $voyage */
        $voyage = $this->voyagesRepo->findById($voyage_id);
        
        
        $this->validateAction($voyage);
        
        
        
        $voyageService = new VoyageService();


        \DB::beginTransaction();
        try {

            $voyageService->shipMoor($voyage_id);

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }

    private function validateAction(Voyage $voyage)
    {
        if ($voyage->status !== Voyage::STATUS_IN_SAIL) {
            
            throw new StateException;
        }
    }
}
