<?php

namespace App\Modules\Work\Persistence\Dao\Worker;

use App\Modules\Work\Domain\Entities\Worker\Worker;

class WorkerDao
{
    private $table = 'work_workers';

    public function findById(int $id)
    {
        $order = \DB::table($this->table)
            ->select(['id', 'team_id', 'status'])

            ->find($id);

        return $order;
    }

    public function save(Worker $worker)
    {
        if ($worker->id != null) {

            \DB::table($this->table)
                ->where('id', $worker->id)
                ->update([
                    'status'  => $worker->status,
                    'acceptor_worker_id'   => $worker->acceptor_worker_id,
                ]);
        }
    }

}
