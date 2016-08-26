<?php

namespace App\Modules\Work\Domain\Handlers\Worker;

use App\Modules\Work\Domain\Commands\Worker\AddInstrument;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerInstrumentsRepo;
use App\Persistence\Models\Work\Worker\WorkerInstrument;

class AddInstrumentHandler
{
    /** @var WorkerInstrumentsRepo */
    private $workerInstruments;

    public function __construct()
    {
        $this->workerInstruments = app('WorkerInstrumentsRepo');
    }

    public function handle(AddInstrument $command)
    {
        /** @var WorkerInstrument $instrument */
        $instrument = $this->workerInstruments->findByCode($command->worker_id, $command->instrumentCode);

        if (null == $instrument) {

            $this->workerInstruments->create(
                $command->worker_id,
                $command->instrumentCode,
                $command->charge
            );
        }
        else {

            $instrument->incrCharge($command->charge);

            $this->workerInstruments->update($instrument);
        }
    }
}
