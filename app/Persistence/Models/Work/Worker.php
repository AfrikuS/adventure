<?php

namespace App\Persistence\Models\Work;

use App\Exceptions\NotEnoughMaterialException;
use App\Persistence\Models\DataObject;

class Worker extends DataObject
{
    protected function getAttributes()
    {
        return ['id', 'team_id', 'status',

                'materials'];
    }

    public function subtractMaterial($code, $amount)
    {
        $material = $this->findMaterialByCode($code);

        if ($material->value < $amount) {
            throw new NotEnoughMaterialException;
        }

        $material->value -= $amount;
    }

    public function findMaterialByCode($code)
    {
        $material = array_filter($this->materials, function ($material) use ($code) {
            return $material->code === $code;
        });

        return array_pop($material);
    }

}
