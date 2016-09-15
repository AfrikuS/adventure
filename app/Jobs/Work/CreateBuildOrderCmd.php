<?php

namespace App\Jobs\Work;

use App\Jobs\Job;
use App\Modules\Hero\Persistence\Repositories\HeroRepo;
use App\Modules\Timer\Persistence\Dao\BodalkaResultDao;
use App\Modules\Timer\Persistence\Repositories\TimersRepo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateBuildOrderCmd extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $user_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        print "hello\n";

//        /** @var HeroRepo $heroRepo */
//        $heroRepo = app('HeroRepo');

//        $hero = $heroRepo->getHero($this->user_id);
//
//        $hero->incrementOil(1);
//
//        $heroRepo->updateResources($hero);

        /** @var TimersRepo $timersRepo */
        $timersRepo = app('TimersRepo');

        $timer = $timersRepo->findBy($this->user_id, 'bodalka');
        
        print $timer->duration_seconds . " " . $timer->code. "\n";


        $resultDao = new BodalkaResultDao();
        $result = $resultDao->create($this->user_id, 1, 1);

    }
}

