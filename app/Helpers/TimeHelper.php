<?php

namespace App\Helpers;

use Carbon\Carbon;

class TimeHelper
{
    public static function leftSecs($datetime)
    {
        $leftSeconds = Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->diffInSeconds();
        return ($leftSeconds > 0 ? $leftSeconds : 0);
    }
}
