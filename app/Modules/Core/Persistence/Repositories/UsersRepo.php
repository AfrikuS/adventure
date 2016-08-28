<?php

namespace App\Modules\Core\Persistence\Repositories;

use App\Modules\Core\Entities\AppUser;
use App\Modules\Core\Persistence\Dao\UsersDao;
use App\Modules\Core\Facades\EntityStore;

class UsersRepo
{
    /** @var UsersDao */
    private $usersDao;

    public function __construct(UsersDao $usersDao)
    {
        $this->usersDao = $usersDao;
    }

    public function find($user_id)
    {
        $user = EntityStore::get(AppUser::class, $user_id);
        
        if (null !== $user) {
           return $user;
        }
        
        $userData = $this->usersDao->find($user_id);
        
        $user = new AppUser($userData);

        EntityStore::add($user, $user->id);
        
        return $user;
    }

    public function getExcluding($user_id)
    {
        $opponents_ids = $this->usersDao->getIdsExclude($user_id);

        return $opponents_ids;
    }
}
