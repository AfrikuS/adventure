<?php

namespace App\Handlers\Commands;

class AddEmploymentDomain
{
//    use InteractsWithQueue, SerializesModels;

    public $title;
    public $code;
    public $mosaicSize;

    public function __construct($title, $code, $mosaicSize)
    {
        $this->title = $title;
        $this->code = $code;
        $this->mosaicSize = $mosaicSize;
    }

    public function handle()
    {
        die('handling myself');

    }

}
