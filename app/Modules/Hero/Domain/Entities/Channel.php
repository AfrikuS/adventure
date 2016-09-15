<?php

namespace App\Modules\Hero\Domain\Entities;

class Channel
{
    public $id;
    public $from_user_id;
    public $to_user_id;
    public $resource;
    public $tax_percent;

    public $fromUser;
    public $toUser;

    public function __construct(\stdClass $channelData)
    {
        $this->id = $channelData->id;
        $this->from_user_id = $channelData->from_user_id;
        $this->to_user_id = $channelData->to_user_id;
        $this->resource = $channelData->resource;
        $this->tax_percent = $channelData->tax_percent;
    }

    public function setFromUser($fromUser)
    {
        $this->fromUser = $fromUser;
    }

    public function setToUser($toUser)
    {
        $this->toUser = $toUser;
    }
    
    

}
