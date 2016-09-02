<?php

namespace App\Modules\Employment\View\Presenters;

use Laracasts\Presenter\Presenter;

class LorePresenter extends Presenter
{
    public function mosaicTable()
    {
        return implode(' : ', $this->mosaic);
    }
}
