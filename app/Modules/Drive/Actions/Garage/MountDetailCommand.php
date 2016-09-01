<?php

namespace App\Modules\Drive\Actions\Garage;

use App\Modules\Drive\Domain\Entities\Driver;
use App\Modules\Drive\Domain\Entities\Garage\Detail;
use App\Modules\Drive\Domain\Services\GarageVehicleService;
use App\Modules\Drive\Persistence\Repositories\DriversRepo;
use App\Modules\Drive\Persistence\Repositories\Vehicle\DetailsRepo;
use Finite\Exception\StateException;

class MountDetailCommand
{
//    /** @var VehiclesRepo */
//    private $vehiclesRepo;

    /** @var DetailsRepo */
    private $detailsRepo;

    /** @var DriversRepo */
    private $driversRepo;

    public function __construct()
    {
//        $this->vehiclesRepo = app('DriveVehiclesRepo');

        $this->detailsRepo = app('DriveDetailsRepo');

        $this->driversRepo = app('DriveDriversRepo');
    }

    public function mountDetail($detail_id, $driver_id)
    {
        $this->validateAction($detail_id, $driver_id);


        /** @var Driver $driver */
        $driver = $this->driversRepo->find($driver_id);



        $vehicleService = new GarageVehicleService();

        
        
        \DB::beginTransaction();
        try {


            $vehicleService->mountDetail($detail_id, $driver->vehicle_id);

            
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }

    public function validateAction($detail_id, $driver_id)
    {
        /** @var Detail $detail */
        $detail = $this->detailsRepo->findDetail($detail_id);

        /** @var Driver $driver */
        $driver = $this->driversRepo->find($driver_id);


        if (! $detail->isOwner($driver)) {
            throw new StateException('У вас нет такой детали');
        }

        if ($detail->isMounted()) {
            throw new StateException('Эта деталь уже стоит');
        }
    }
}
