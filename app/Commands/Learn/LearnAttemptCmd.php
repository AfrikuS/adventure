<?php

namespace App\Commands\Learn;

use App\Models\Learn\Lore;
use App\Services\Session\MessageService;

class LearnAttemptCmd
{
    private $sessionMsgService;

    public function __construct()
    {
        $this->sessionMsgService = new MessageService();
    }

    public function attempt($loreSphere, $user_id)
    {

        $lore = Lore::find($user_id);

        $frame = rand(0, strlen($lore->mosaic) - 1);

        if ($this->isFortune($frame, $lore->mosaic))
        {
            $lore->addKnowledge($frame);
            $lore->save();

            $this->sessionMsgService->infoMessage('ozarenie. new learn', 'msg_code');

        }
        else
        {
            $this->sessionMsgService->infoMessage('repeat. is mom of the learn', 'msg_code');
        }

    }

    private function isFortune($frame, $mosaicArr)
    {
        $value = $mosaicArr[$frame];

        return $value == '0';
    }
}
