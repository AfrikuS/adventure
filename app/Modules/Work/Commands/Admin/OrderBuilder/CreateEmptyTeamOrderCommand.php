<?php

namespace App\Modules\Work\Commands\Admin\OrderBuilder;

use App\Repositories\Work\Team\TeamOrderRepositoryObj;

class CreateEmptyTeamOrderCommand
{
    /** @var TeamOrderRepositoryObj */
    private $teamOrderRepo;

    public function __construct(TeamOrderRepositoryObj $teamOrderRepo)
    {
        $this->teamOrderRepo = $teamOrderRepo;
    }

    public function createEmptyTeamOrder()
    {

        \DB::beginTransaction();
        try {

            $order = $this->teamOrderRepo->createTeamOrderDraft();

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

        return $order;
    }
}
