<?php

namespace App\Modules\Work\Commands\Admin\OrderBuilder;

use App\Entities\Work\TeamOrderDraftEntity;

class SettingMaterialsValuesCommand
{
    public function fillMaterialValues(TeamOrderDraftEntity $orderDraft, array $materialsValues)
    {
        
        \DB::beginTransaction();
        try {
            
            foreach ($materialsValues as $code => $value) {

                $orderDraft->fillMaterialValueByCode($code, $value);
            }

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }
}
