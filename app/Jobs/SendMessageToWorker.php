<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Core\Hero;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMessageToWorker extends Job implements ShouldQueue
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

        $hero = Hero::find($this->user_id);

        $hero->increment('oil', 1);

    }
}
