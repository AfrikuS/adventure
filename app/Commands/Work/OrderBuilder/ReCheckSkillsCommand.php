<?php

namespace App\Commands\Work\OrderBuilder;

use App\Factories\Work\TeamOrderFactory;
use App\Entities\Work\TeamOrderDraftEntity;

class ReCheckSkillsCommand
{

    public function reCheckSkills(TeamOrderDraftEntity $orderDraft, $checkedSkillsCodes)
    {
        \DB::beginTransaction();
        try {


            $orderSkillsCodes = $orderDraft->getSkillsCodes();

            // удялить те, к-ые есть в старом но нет в новом
            $deleteSkillsCodes = array_diff($orderSkillsCodes, $checkedSkillsCodes);
            
            if (count($deleteSkillsCodes) > 0) {

                $orderDraft->deleteOldSkills($deleteSkillsCodes);
            }

            // Добавить те, к-ых не было в старой версии
            foreach ($checkedSkillsCodes as $checkedCode) {
                
                if (!in_array($checkedCode, $orderSkillsCodes)) {

                    // add checked to order_skills                         // todo redo
                    $checkedSkill = TeamOrderFactory::createTeamOrderSkill($orderDraft, $checkedCode);
                    
                    $orderDraft->addSkill($checkedSkill);
                }
            }


        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        
        \DB::commit();
    }

}
