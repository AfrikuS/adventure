<?php

namespace App\Infrastructure\Events;

class SendOneWeekEmailListener implements Listener
{
    public function handle($event)
    {
        Mailer::queue(...);
        // actions, logic
    }
}
