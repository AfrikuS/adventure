<?php

namespace App\Commands\Employment\School;

use App\Domain\Services\Employment\Lore\LearnLoreService;

class ProcessSchoolTaskCmd
{
    public function process($lore_id, $user_id)
    {

        $loreService = new LearnLoreService();

        \DB::beginTransaction();
        try {


            $loreService->attemptLearnSkill($lore_id, $user_id);


        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();

    }
}
