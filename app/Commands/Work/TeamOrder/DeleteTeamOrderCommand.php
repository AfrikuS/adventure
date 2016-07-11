<?php

namespace App\Commands\Work\TeamOrder;

use App\Models\Work\Order;
use App\Models\Work\OrderMaterials;
use App\Models\Work\OrderSkill;
use App\Repositories\Work\Team\TeamOrderRepositoryObj;
use App\Entities\Work\TeamOrderEntity;

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
        // todo validate on completed status
        /** @var TeamOrderEntity $teamOrderEntity */
        $teamOrderEntity = $this->teamOrderRepo->findOrderWithMaterialsAndSkillsById($order_id);

        \DB::beginTransaction();
        try {

            $material_ids = $teamOrderEntity->materials->map(function ($material, $key) {
                return $material->id;
            })->toArray();
            
            OrderMaterials::destroy($material_ids);

            
            

            $skills_ids = $teamOrderEntity->skills->map(function ($skill, $key) {
                return $skill->id;
            })->toArray();
            
            OrderSkill::destroy($skills_ids);

            
            
            Order::destroy($order_id);
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }


}
