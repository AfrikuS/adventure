<?php

namespace App\Models\Macro;

use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
    protected $table      = 'macro_timers';
    protected $primaryKey = 'id';
    public    $timestamps = false;
}
