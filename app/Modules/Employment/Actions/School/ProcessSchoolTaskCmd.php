<?php

namespace App\Modules\Employment\Actions\School;

use App\Modules\Employment\Domain\Services\Lore\LearnLoreService;

class ProcessSchoolTaskCmd
{
    public function process($user_id, $lore_id)
    {

        $loreService = new LearnLoreService();

        \DB::beginTransaction();
        try {


            $loreService->attemptLearnInSchool($user_id, $lore_id);


        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }
}
