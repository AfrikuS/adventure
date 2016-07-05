<?php

namespace App\Services\Transfers\Shop;

use App\Models\Core\Hero;
use App\Models\Work\PriceMaterial;
use App\Models\Work\Worker\WorkerMaterial;
use App\Services\Transfers\ITransfer;

/** @deprecated    */
class PurchaseMaterialTransfer implements ITransfer
{
    /** @var  Hero */
    private $hero;
    /** @var  WorkerMaterial */
    private $workerMaterial;
    /** @var  PriceMaterial */
    private $shopMaterial;

    public function __construct(Hero $hero, WorkerMaterial $workerMaterial, PriceMaterial $shopMaterialPrice)
    {
        $this->hero = $hero;
        $this->workerMaterial = $workerMaterial;
        $this->shopMaterial = $shopMaterialPrice;
    }

    public function execute()
    {
        $this->workerMaterial->increment('value', 70);

    }
}
