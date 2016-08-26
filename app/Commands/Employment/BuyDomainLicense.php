<?php

namespace App\Commands\Employment;

use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Bus;

class BuyDomainLicense implements Dispatcher
{
    use DispatchesCommands;

    protected $user, $podcast;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(User $user, Podcast $podcast)
    {
        $this->user = $user;
        $this->podcast = $podcast;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        // Handle the logic to purchase the podcast...

        Bus::dispatch()

        event(new PodcastWasPurchased($this->user, $this->podcast));
    }

}
