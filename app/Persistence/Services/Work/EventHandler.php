<?php

namespace App\Persistence\Services\Work;

class EventHandler
{
    public static function execute(IDomainEvent $event)
    {
        $event->execute();
    }
}
