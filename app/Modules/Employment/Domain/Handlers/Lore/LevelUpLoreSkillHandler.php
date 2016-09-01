<?php

namespace App\Modules\Employment\Domain\Handlers\Lore;


use App\Modules\Employment\Domain\Commands\Lore\LevelUpLoreSkill;
use App\Modules\Employment\Persistence\Repositories\LoreRepo;

class LevelUpLoreSkillHandler
{
    /** @var LoreRepo */
    private $loreRepo;

    public function __construct()
    {
        $this->loreRepo = app('LoreRepo');
    }

    public function handle(LevelUpLoreSkill $command)
    {
        $lore = $this->loreRepo->find($command->lore_id);

        
        $lore->upUnitOfLore($command->skillIndex);

        
        $this->loreRepo->updateMosaic($lore);
    }
}
