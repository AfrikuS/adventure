<?php

namespace App\Models\Mass;

use Illuminate\Database\Eloquent\Model;

class Boss extends Model
{
    protected $table      = 'mass_bosses';
    public    $timestamps = false;
//    protected $fillable   = ['title', 'code', 'duration_seconds'];

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'mass_boss_users_rels', 'boss_id', 'user_id');
    }
}
