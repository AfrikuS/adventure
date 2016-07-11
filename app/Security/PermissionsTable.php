<?php

namespace App\Security;

use App\Contracts\IUser;
use Illuminate\Contracts\Config\Repository;

class PermissionsTable
{
    private $table;
    private $repo;

    /**
     * PermissionsTable constructor.
     * @param $table
     */
    public function __construct($table, Repo $repo)
    {
        $this->repo = $repo;

        $this->table = [
            'work:individual-orders:view' => function (IUser $user) use ($repo) {
                $worker = $repo->findById($user->id());

                return $worker->isActivePayer();
            }
        ];
    }

}
