<?php

namespace App\Modules\Employment\Domain\Entities;

class Domain
{
    public $id;
    public $code;
    public $title;
    public $mosaic_size;

    /**
     * Domain constructor.
     * @param $code
     * @param $id
     * @param $mosaic_size
     * @param $title
     */
    public function __construct($id, $code, $title, $mosaic_size)
    {
        $this->code = $code;
        $this->id = $id;
        $this->mosaic_size = $mosaic_size;
        $this->title = $title;
    }

}
