<?php

namespace App\ViewData\Work;

use Illuminate\Database\Eloquent\Collection;

class ShopValueObject
{
    /** @var Collection $prices*/
    private $prices;

    /**
     * @param Collection $prices
     */
    public function __construct(Collection $prices)
    {
        $this->prices = $prices;
    }

    /**
     * @return Collection
     */
    public function getProducts()
    {
        return $this->prices;
    }
}
