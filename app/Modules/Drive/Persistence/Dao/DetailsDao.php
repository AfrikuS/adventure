<?php

namespace App\Modules\Drive\Persistence\Dao;

use App\Exceptions\Persistence\EntityNotFound_Exception;

class DetailsDao
{
    private $table = 'drive_details';

    const MOUNTED_STATUS = 'mounted';
    const UNMOUNTED_STATUS = 'unmounted';

    const DETAIL_NORMAL_STATUS = 'normal';

    public function create($title, $kind_id, $nominalValue, $driver_id)
    {
        $detail_id =
            \DB::table($this->table)->insertGetId([
                'title' => $title,
                'kind_id' => $kind_id,
                'nominal_value' => $nominalValue,

                'status' => self::DETAIL_NORMAL_STATUS,
                'state_percent' => 100,
                'mount_status' => self::UNMOUNTED_STATUS,

                'owner_driver_id' => $driver_id,
                'vehicle_id' => null,
            ]);

        return $detail_id;
    }

    public function getMountedByVehicle($vehicle_id)
    {
        $details =
            \DB::table($this->table . ' AS d')
                ->select(['d.id', 'd.title', 'd.kind_id', 'd.nominal_value', 'd.status', 'd.state_percent',
                          'ki.title as kind_title'])
                ->join('drive_catalog_detail_kinds AS ki',  'd.kind_id',  '=', 'ki.id')

                ->where('d.vehicle_id', $vehicle_id)
                ->where('d.mount_status', self::MOUNTED_STATUS)
                ->get();

        return $details;
    }

    public function getUnmountedDetails($driver_id)
    {
        $details =
            \DB::table($this->table . ' AS d')
                ->select(['d.id', 'd.title', 'd.kind_id', 'd.nominal_value', 'd.status', 'd.state_percent',
                          'ki.title as kind_title'])
                ->join('drive_catalog_detail_kinds AS ki',  'd.kind_id',  '=', 'ki.id')

                ->where('d.owner_driver_id', $driver_id)
                ->where('d.mount_status', self::UNMOUNTED_STATUS)
                ->get();

        return $details;
    }

    public function findDetail($detail_id)
    {
        $detail =
            \DB::table($this->table)

                ->select(['id', 'title', 'mount_status', 'nominal_value', 'status', 'state_percent', 
                          'owner_driver_id', 'vehicle_id'])
//                ->where('mount_status', self::UNMOUNTED_STATUS)
//                ->where('vehicle_id', null)
                ->find($detail_id);

        return $detail;
    }

    public function updateMountStatus($id, $mountStatus, $vehicle_id)
    {
        return
            \DB::table($this->table)
                ->where('id', $id)
                ->update([
                    'mount_status' => $mountStatus,
                    'vehicle_id'   => $vehicle_id,
                ]);
    }



    public function findDetailForUnmount($detail_id)
    {
        $detail =
            \DB::table($this->table)
                ->select(['id', 'mount_status', 'vehicle_id'])

                ->where('mount_status', self::MOUNTED_STATUS)
                ->where('vehicle_id', null)
                ->find($detail_id);

        if (null === $detail) {
            
            throw new EntityNotFound_Exception;
        }
        
        return $detail;
    }
}
