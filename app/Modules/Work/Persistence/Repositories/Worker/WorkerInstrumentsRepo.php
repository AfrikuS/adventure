<?php

namespace App\Modules\Work\Persistence\Repositories\Worker;

use App\Modules\Work\Domain\Entities\Worker\WorkerInstrument;
use App\Modules\Work\Persistence\Dao\Worker\WorkerInstrumentsDao;

class WorkerInstrumentsRepo
{
    /** @var WorkerInstrumentsDao */
    private $instrumentsDao;

    public function __construct()
    {
        $this->instrumentsDao = new WorkerInstrumentsDao();
    }

    public function findByCode($worker_id, $code)
    {
        $instrumentData = $this->instrumentsDao->find($worker_id, $code);

        if (null == $instrumentData) {
            return null;
        }

        return new WorkerInstrument($instrumentData);
    }

    public function getBy($worker_id)
    {
        $instrumentsData = $this->instrumentsDao->getInstruments($worker_id);
        
        return $instrumentsData;
    }
    

    public function create($worker_id, $code, $chargeAmount = 0)
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
