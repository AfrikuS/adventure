<?php

namespace App\Queries\Battle;

use App\Models\Auth\User;
use App\Repositories\AttackRepository;
use App\Repositories\Battle\TeaserRepository;

class SearchOpponentQuery
{
    /** @var  TeaserRepository */
    private $teaserRepo;

    public function __construct(TeaserRepository $teaserRepo)
    {
        $this->teaserRepo = $teaserRepo;
    }

    public function searchOpponent($user_id)
    {
        $allUsers_ids = User::select('id')->where('id', '!=', $user_id)->take(5)->get()->map(function ($item, $key) {
            return $item->id;
        })->toArray();

        $atackedUsers_ids = $this->teaserRepo->getAttackedIdsByUserId($user_id);
        // todo xz
        $atackedUsers_ids = array_map(function($user) {
            return $user->defense_user_id;
        }, $atackedUsers_ids);

        // intersect
        $validUsers = array_diff($allUsers_ids, $atackedUsers_ids);

        $validUsers_ids = array_values($validUsers);
        
        return $validUsers_ids;

    }
}
