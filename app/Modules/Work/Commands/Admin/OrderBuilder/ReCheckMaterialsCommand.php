<?php

namespace App\Modules\Work\Commands\Admin\OrderBuilder;

use App\Factories\Work\TeamOrderFactory;
use App\Repositories\Work\Team\TeamOrderRepositoryObj;
use App\Entities\Work\TeamOrderDraftEntity;

class ReCheckMaterialsCommand // command-mutator-entity
{
    public function reCheckMaterials(TeamOrderDraftEntity $orderDraft, $checkedMaterialsCodes)
    {
        $orderMaterialsCodes = $orderDraft->getMaterialsCodes();

        // удялить те, к-ые есть в старом но нет в новом
        $deleteMaterialsCodes = array_diff($orderMaterialsCodes, $checkedMaterialsCodes);

        
        \DB::beginTransaction();
        try {
            
            if (count($deleteMaterialsCodes) > 0) {

                $orderDraft->deleteOldMaterials($deleteMaterialsCodes);
            }

            // Добавить те, к-ых не было в старой версии
            foreach ($checkedMaterialsCodes as $checkedCode) {

                if (!in_array($checkedCode, $orderMaterialsCodes)) {

                    // add checked to order_skills                         // todo redo
                    $checkedSkill = TeamOrderFactory::createTeamOrderMaterial($orderDraft, $checkedCode);

                    $orderDraft->addMaterial($checkedSkill);
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
