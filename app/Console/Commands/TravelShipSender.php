<?php

namespace App\Console\Commands;

use App\Domain\SeaActions;
use App\Models\Sea\TravelShip;
use App\Repositories\Generate\EntityGenerator;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Console\Command;

class TravelShipSender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'travel_sender';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send ships to the travel';
    
    protected $faker;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->faker = Factory::create();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        EntityGenerator::createSeaTravel();
    }
}
