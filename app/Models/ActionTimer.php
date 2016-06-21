<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionTimer extends Model
{
    protected $table      = 'action_timers';
    public    $timestamps = false;
    protected $fillable   = ['action_code', 'user_id', 'date_time'];
}
