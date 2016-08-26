<?php

namespace App\Commands\Drive;

use App\Models\Drive\Catalogs\DetailTitle;
use App\Models\Drive\DetailOffer;
use App\Repositories\Drive\DetailRepository;

class UpdateDetailOffersCommand
{
    /** @var DetailRepository */
    private $detailRepo;

    public function __construct(DetailRepository $detailRepo)
    {
        $this->detailRepo = $detailRepo;
    }

    public function updateOffers($driver_id)
    {

        $detailsTitlesArr = DetailTitle::select('kind_id', 'title')->get()->toArray();
        
        \DB::beginTransaction();
        try {

            // delete old offers
            $this->detailRepo->deleteOffersByDriverId($driver_id);


            $faker = \Faker\Factory::create();


            for ($i = 0; $i < 2; $i++)
            {
//            $detail = $faker->unique()->randomElement($materialsCodes->toArray());
                $detail = $faker->randomElement($detailsTitlesArr);

                DetailOffer::create([
                    'title' => $detail['title'],
                    'kind_id' => $detail['kind_id'],
                    'nominal_value' => rand(12, 25),
                    'driver_id' => $driver_id,
                ]);
            }

            
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }

}
