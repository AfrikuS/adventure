<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TravelShipCleaner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'travel_cleaner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $expiredTravels = DB::table('sea_travel_ships')
            ->select('sea_travel_ships.id AS id')
//            ->addSelect('sea_travel_ships.user_id AS user_id')
            ->addSelect(DB::raw('TIMESTAMPDIFF(SECOND, now(), sea_travel_ships.date_sending) AS duration_seconds'))
            ->havingRaw('duration_seconds < 0')
            ->get();

        foreach ($expiredTravels as $travel) {
            DB::beginTransaction();
            TravelShip::destroy($travel->id);
            DB::commit();
        }

    }
}
