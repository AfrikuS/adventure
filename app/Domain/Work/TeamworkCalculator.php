<?php

namespace App\Domain\Work;

use App\Models\Work\PrivateTeam;

class TeamworkCalculator
{
    public static function privateTeamWork(PrivateTeam $team)
    {
        foreach ($team->partners as $partner) {
            $res = $partner->resources;
            $res->water += 5;
            $res->save();
        }
    }
}
