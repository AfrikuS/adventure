<?php

namespace App\Commands\Work\TeamOrder;

use App\Models\Work\Team\TeamOrder;
use App\Models\Work\Team\TeamOrderMaterial;
use App\Models\Work\Team\TeamOrderSkill;
use App\Repositories\Work\Team\TeamOrderRepositoryObj;
use App\StateMachines\Work\TeamOrderEntity;

class DeleteTeamOrderCommand
{
    /** @var TeamOrderRepositoryObj */
    private $teamOrderRepo;

    public function __construct(TeamOrderRepositoryObj $teamOrderRepo)
    {
        $this->teamOrderRepo = $teamOrderRepo;
    }

    public function deleteTeamOrder($order_id)
    {
        /** @var TeamOrderEntity $teamOrderEntity */
        $teamOrderEntity = $this->teamOrderRepo->findOrderWithMaterialsAndSkillsById($order_id);

        \DB::beginTransaction();
        try {

            $material_ids = $teamOrderEntity->materials->map(function ($material, $key) {
                return $material->id;
            })->toArray();
            
            TeamOrderMaterial::destroy($material_ids);

            
            

            $skills_ids = $teamOrderEntity->skills->map(function ($skill, $key) {
                return $skill->id;
            })->toArray();
            
            TeamOrderSkill::destroy($skills_ids);

            
            
            TeamOrder::destroy($order_id);
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }


}
