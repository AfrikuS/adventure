<?php

namespace App\Commands\Employment;

use App\Domain\Services\Employment\Lore\LoreService;
use App\Persistence\Repositories\Employment\LoreRepo;
use Illuminate\Support\Facades\App;

class WorkProcessCmd
{
    /** @var LoreRepo */
    private $loreRepo;

    public function __construct()
    {
        $this->loreRepo = app('LoreRepo'); // new LoreRepo();
    }

    public function workProcess($lore_id)
    {
//        $lore = $this->loreRepo->find($lore_id);

        // LEarnLoreService
        
        
        
        $loreService = new LoreService();
        
        $loreService->attemptUpSkill($lore_id);
        
        

    }
}
