<?php

namespace App\Entities\Work;

use App\Models\Work\Catalogs\Material;

trait OrderWithMaterialsTrait
{
    public function getMaterialByCode($code)
    {
        $materials = $this->model->materials;

        $index = $materials->search(function ($material, $key) use ($code) {
            return $material->code === $code;
        });

        if (is_int($index)) {
            return $materials->get($index);
        }

        return null;
    }

    private function isAllMaterialsStocked(): bool
    {
        /** @var Material $material */
        foreach ($this->model->materials as $material) {
            if ($material->need > $material->stock) {
                return false;
            }
        }

        return true;
    }
}