<?php

namespace App\Persistence\Services\Work;

use App\Persistence\Models\Work\Worker\WorkerInstrument;
use App\Persistence\Repositories\Work\WorkerInstrumentsRepo;

class AddInstrumentEvent
{
    /** @var WorkerInstrumentsRepo */
    private $workerInstrumentsRepo;

    public function __construct(WorkerInstrumentsRepo $workerInstrumentsRepo)
    {
        $this->workerInstrumentsRepo = $workerInstrumentsRepo;
    }

    public function handle($worker_id, $code, $chargeAmount)
    {
        /** @var WorkerInstrument $instrument */
        $instrument = $this->workerInstrumentsRepo->getByCode($worker_id, $code);

        if (null == $instrument) {

            $this->workerInstrumentsRepo->create($worker_id, $code, $chargeAmount);
        }
        else {

            $instrument->incrCharge($chargeAmount);

            $this->workerInstrumentsRepo->update($instrument);
        }
    }}
