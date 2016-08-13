<?php

namespace App\Persistence\Repositories\Work;

use App\Persistence\Dao\Work\WorkerInstrumentsDao;
use App\Persistence\Models\Work\Worker\WorkerInstrument;

class WorkerInstrumentsRepo
{
    /** @var WorkerInstrumentsDao */
    private $instrumentsDao;

    public function __construct()
    {
        $this->instrumentsDao = new WorkerInstrumentsDao();
    }

    public function getByCode($worker_id, $code)
    {
        $instrumentData = $this->instrumentsDao->find($worker_id, $code);

        if (null == $instrumentData) {
            return null;
        }

        return new WorkerInstrument($instrumentData);
    }

    public function create($worker_id, $code, $chargeAmount)
    {
        $instrument = new \stdClass();
        $instrument->worker_id = $worker_id;
        $instrument->code = $code;
        $instrument->skill_level = $chargeAmount;

        $this->instrumentsDao->create($instrument);
    }

    public function update($instrument)
    {
        $this->instrumentsDao->update($instrument);
    }
}
