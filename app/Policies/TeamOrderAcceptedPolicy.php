<?php

namespace App\Policies;

use App\Entities\Work\TeamOrderEntity;

class TeamOrderAcceptedPolicy
{
    public function check($user, TeamOrderEntity $teamOrder)
    {
        return $teamOrder->isAccepted();
    }
}
