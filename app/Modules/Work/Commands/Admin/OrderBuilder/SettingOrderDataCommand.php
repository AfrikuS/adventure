<?php

namespace App\Modules\Work\Commands\Admin\OrderBuilder;

use App\Entities\Work\TeamOrderDraftEntity;

class SettingOrderDataCommand
{
    public function fillOrderData(TeamOrderDraftEntity $orderDraft, $orderValues)
    {
        \DB::beginTransaction();
        try {

            $orderDraft->fillOrderData($orderValues);

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();

    }
}
