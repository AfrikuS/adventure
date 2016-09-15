<?php

namespace App\Modules\Drive\Persistence\Dao;

use App\Exceptions\Persistence\EntityNotFound_Exception;
use App\Infrastructure\IdentityMap;
use App\Modules\Drive\Persistence\Dao\Catalogs\DetailsKindsDao;
use Illuminate\Support\Collection;

class DetailsOffersDao
{
    private $table = 'drive_detail_offers';

/*CREATE TABLE IF NOT EXISTS `` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`title` VARCHAR(255) NOT NULL,
`kind_id` INT UNSIGNED NOT NULL,
`nominal_value` INT UNSIGNED NOT NULL,
`driver_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (id),
FOREIGN KEY (kind_id) REFERENCES drive_catalog_detail_kinds(id),
FOREIGN KEY (driver_id) REFERENCES drive_drivers(id)
    */
    
    public function find($id)
    {
        $offerData = \DB::table($this->table)
            ->select(['id', 'title', 'kind_id', 'nominal_value', 'driver_id'])
            ->find($id);
        
        if (null === $offerData) {
            
            throw new EntityNotFound_Exception;
        }
        
        return $offerData;
    }

    public function getByDriver($driver_id)
    {
        $offers = \DB::table($this->table)
            ->select(['id', 'title', 'kind_id', 'nominal_value', 'driver_id'])
            ->where('driver_id', $driver_id)
            ->get();

        return $offers;
        
    }
    
    /*    public function getAll()
        {
            $domains = \DB::table($this->table)
                ->select(['id', 'code', 'title', 'mosaic_size'])
                ->get();
    
            return $domains;
        }
    */

    public function create($title, $kind_id, $nominal, $driver_id)
    {
        $offer_id =
            \DB::table($this->table)->insertGetId([
                'title' => $title,
                'kind_id' => $kind_id,
                'nominal_value' => $nominal,
                'driver_id' => $driver_id,
            ]);

        return $offer_id;
    }

    public function getWithKindsByDriver($driver_id)
    {
        $offers = \DB::table($this->table . ' AS of')
            ->select(['of.id', 'of.title', 'of.kind_id', 'of.nominal_value', 'of.driver_id', 'ki.title AS kind_title'])
            ->join('drive_catalog_detail_kinds AS ki',  'of.kind_id',  '=', 'ki.id')
            ->where('of.driver_id', $driver_id)
            ->get();


/*        $detailsOffers = DetailOffer::select('id', 'kind_id', 'title')
            ->where('driver_id', $driver_id)
            ->with('kind')
            ->get();*/

        return Collection::make($offers);

    }

    public function delete($id)
    {
        return
            \DB::table($this->table)->delete($id);
    }

    public function deleteByDriver($driver_id)
    {
        return 
            \DB::table($this->table)->where('driver_id', $driver_id)->delete();
    }
}
