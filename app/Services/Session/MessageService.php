<?php

namespace App\Services\Session;

class MessageService
{
    public function infoMessage($message, $code)
    {
        // define message-type
        // define message-content
        // getting msg by code
        
        \Session::flash('message', $message);
    }
}
