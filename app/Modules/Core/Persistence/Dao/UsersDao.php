<?php

namespace App\Modules\Core\Persistence\Dao;

class UsersDao
{
    private $table = 'users';

    public function getIdsExclude($user_id)
    {
        $users_ids =
            \DB::table($this->table)
                ->where('id', '<>', $user_id)
                ->pluck('id');

        return $users_ids;
    }

    public function find($user_id)
    {
        $userData =
            \DB::table($this->table)
                ->select(['id', 'name'])
                ->find($user_id);

        return $userData;
    }
}
