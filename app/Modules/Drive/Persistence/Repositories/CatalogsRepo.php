<?php

namespace App\Modules\Drive\Persistence\Repositories;

use App\Modules\Drive\Persistence\Dao\Catalogs\DetailsKindsDao;
use App\Modules\Drive\Persistence\Dao\Catalogs\DetailsTitlesDao;

class CatalogsRepo
{
    /** @var DetailsKindsDao */
    private $detailsKinds;
    
    /** @var DetailsTitlesDao */
    private $detailsTitles;

    public function __construct()
    {
        $this->detailsKinds = new DetailsKindsDao();
        $this->detailsTitles = new DetailsTitlesDao();
    }

    public function getDetailsKinds()
    {
        $kinds =  $this->detailsKinds->get();
        
        return $kinds;
    }

    public function getDetailsTitles()
    {
        $titles =  $this->detailsTitles->get();

        return $titles;
    }

    public function createDetailKind($kind)
    {
        return $this->detailsKinds->create($kind);
        
    }

    public function createDetailTitle($title, $kind_id)
    {
        $this->detailsTitles->create($title, $kind_id);
    }
}
