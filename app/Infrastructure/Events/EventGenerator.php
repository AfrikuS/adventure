<?php

namespace App\Infrastructure\Events;

trait EventGenerator
{
    protected $pendingEvents = [];

    protected function raise($event)
    {
        $this->pendingEvents[] = $event;
    }

    public function releaseEvents()
    {
        $events = $this->pendingEvents;

        $this->pendingEvents = [];

        return $events;
    }
}
