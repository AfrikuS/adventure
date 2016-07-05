<?php

namespace App\Services\Transfers;

class TransferExecutor
{
    public function executeTransfer(ITransfer $transfer)
    {
        $transfer->execute();
    }
}
