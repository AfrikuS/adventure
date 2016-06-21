<?php

namespace App\Models\Mass;

use Illuminate\Database\Eloquent\Model;

class BossTimer extends Model
{
    protected $table      = 'mass_boss_timers';
    protected $primaryKey = 'boss_id';
    public    $timestamps = false;
//    protected $fillable   = ['title', 'code', 'duration_seconds'];
}
