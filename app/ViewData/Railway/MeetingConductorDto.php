<?php

namespace App\ViewData\Railway;

class MeetingConductorDto
{
    public $id;
    public $name;
    public $heroRespect;
    public $heroBribes;

    public function __construct($id, $name, $heroRespect, $heroBribes)
    {
        $this->id = $id;
        $this->name = $name;
        $this->heroRespect = $heroRespect;
        $this->heroBribes = $heroBribes;
    }

}
