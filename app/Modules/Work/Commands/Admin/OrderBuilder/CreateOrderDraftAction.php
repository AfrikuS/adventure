<?php

namespace App\Modules\Work\Commands\Admin\OrderBuilder;

use App\Modules\Work\Domain\Services\Order\OrderBuilderService;
use App\Modules\Work\Persistence\Repositories\Order\OrderDraftsRepo;

class CreateOrderDraftAction
{
    /** @var OrderDraftsRepo */
    private $draftsRepo;

    public function __construct()
    {
        $this->draftsRepo = app('OrderDraftsRepo');
    }

    public function createEmptyTeamOrder()
    {

        $builderService = new OrderBuilderService();


        \DB::beginTransaction();
        try {


            $draft_id = $builderService->createDraft();

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

        return $draft_id;
    }
}
