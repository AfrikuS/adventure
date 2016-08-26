<?php

namespace App\Modules\Employment\Domain\Entities;

class LoreDto
{
    public $user_id;
    public $mosaic;

    public function __construct($user_id, $mosaic)
    {
        $this->user_id = $user_id;

        $this->transformMosaic($mosaic);
    }

    private function transformMosaic(string $mosaic)
    {
        $this->mosaic = str_replace(',', ' : ', $mosaic);
    }
}
