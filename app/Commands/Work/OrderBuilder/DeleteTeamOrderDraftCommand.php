<?php

namespace App\Commands\Work\OrderBuilder;

use App\Entities\Work\TeamOrderDraftEntity;
use App\Models\Work\Team\TeamOrder;
use App\Models\Work\Team\TeamOrderMaterial;
use App\Models\Work\Team\TeamOrderSkill;
use App\Repositories\Work\Team\TeamOrderRepositoryObj;
use App\Repositories\Work\TeamOrderDraftRepo;

class DeleteTeamOrderDraftCommand 
{
    /** @var TeamOrderRepositoryObj */
    private $teamOrderRepo;
    /** @var TeamOrderDraftRepo */
    private $teamOrderDraftRepo;

    public function __construct(TeamOrderRepositoryObj $teamOrderRepo)
    {
        $this->teamOrderRepo = $teamOrderRepo;
        $this->teamOrderDraftRepo = new TeamOrderDraftRepo();
    }

    public function deleteTeamOrder($order_id)
    {
        // todo validate on completed status
        /** @var TeamOrderDraftEntity $teamOrderEntity */
        $teamOrderEntity = $this->teamOrderDraftRepo->findOrderDraft($order_id);

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
