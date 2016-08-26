<?php

namespace App\Commands\Railway;

use App\Models\Trade\TradePrice;

class ReindexTradePricesCmd
{
//    /** @var DetailRepository */
//    private $detailRepo;

//    public function __construct(DetailRepository $detailRepo)
//    {
//        $this->detailRepo = $detailRepo;
//    }

    public function reindexPrices()
    {

//        $detailsTitlesArr = DetailTitle::select('kind_id', 'title')->get()->toArray();
        
        \DB::beginTransaction();
        try {

            // delete old offers
//            $this->detailRepo->deleteOffersByDriverId($driver_id);


            TradePrice::where('resource_code', 'oil')
                ->update([
                    'railway_price' => rand(3, 10),
                ]);
            TradePrice::where('resource_code', 'water')
                ->update([
                    'railway_price' => rand(11, 26),
                ]);

            

/*            $faker = \Faker\Factory::create();


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
*/
            
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }

}
