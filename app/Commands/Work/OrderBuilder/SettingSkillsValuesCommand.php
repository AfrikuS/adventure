<?php

namespace App\Commands\Work\OrderBuilder;

use App\Entities\Work\TeamOrderDraftEntity;

class SettingSkillsValuesCommand
{
    
    public function fillSkillsValues(TeamOrderDraftEntity $orderDraft, array $skillsValues)
    {
        \DB::beginTransaction();
        try {

            foreach ($skillsValues as $code => $value) {

                $orderDraft->fillSkillValueByCode($code, $value);
            }

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }
}
