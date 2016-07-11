<?php

namespace App\Entities\Work;

use App\Models\Work\Catalogs\Skill;

trait OrderWithSkillsTrait
{
    public function getSkillByCode($code)
    {
        $index = $this->model->skills->search(function ($skill, $key) use ($code) {
            return $skill->code == $code;
        });

        if (is_int($index)) {
            return $this->model->skills->get($index);
        }

        return null;
    }

    private function isAllSkillsStocked(): bool
    {
        /** @var Skill $skill */
        foreach ($this->model->skills as $skill) {
            if ($skill->need_times > $skill->stock_times) {
                return false;
            }
        }

        return true;
    }

}
