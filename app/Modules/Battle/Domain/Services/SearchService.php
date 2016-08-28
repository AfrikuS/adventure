<?php

namespace App\Modules\Battle\Domain\Services;

use App\Modules\Core\Persistence\Repositories\UsersRepo;

class SearchService
{
    /** @var UsersRepo */
    private $usersRepo;

    public function __construct()
    {
        $this->usersRepo = app('UsersRepo');
    }

    public function searchOpponentFor($user_id)
    {
        $potentialOpponents_ids = $this->usersRepo->getExcluding($user_id);
        
        if ($potentialOpponents_ids === null) {
            return null;
        }
        
        $faker = \Faker\Factory::create();
        $opponent_id = $faker->unique()->randomElement($potentialOpponents_ids);
        
        $opponent = $this->usersRepo->find($opponent_id);
        
        return $opponent;
    }

}
