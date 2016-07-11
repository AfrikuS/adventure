<?php

namespace App\Repositories\Drive;

use App\Entities\Drive\MountDetail;
use App\Models\Drive\Detail;
use App\Models\Drive\DetailOffer;

class DetailRepository
{
    public function findById($id)
    {
       return Detail::find($id);
    }
    
    public function findOfferById($id)
    {
        return DetailOffer::find($id); // todo select fields
    }
    
    public function deleteOldOffers($driver_id)
    {
        
    }

    public function createOffer($driver_id)
    {
        
    }

    public function createByOffer(DetailOffer $offer): Detail
    {
        return Detail::create([
            
            'title' => $offer->title,
            'kind_id' => $offer->kind_id,
            'nominal_value' => $offer->nominal_value,

            'status' => 'normal',
            'state_percent' => 100,
            'mount_status' => 'unmounted',

            'owner_driver_id' => $offer->driver_id,
            'vehicle_id' => null,
        ]);

    }

    public function deleteOffersByDriverId($driver_id)
    {
        return DetailOffer::where('driver_id', $driver_id)->delete();
    }

    public function getVehicleDetailById($detail_id)
    {
        $detail = $this->findById($detail_id); 
            
        return new MountDetail($detail);
    }

    public function getUnmountedDetailsByDriverId($driver_id)
    {
        return Detail::
                    where('owner_driver_id', $driver_id)
                    ->where('mount_status', 'unmounted')
                    ->get();
    }
}
