<?php

namespace App\Models\Battle;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Boss extends Model
{
    protected $table      = 'mass_bosses';
    public    $timestamps = false;
//    protected $fillable   = ['title', 'code', 'duration_seconds'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'mass_boss_users_rels', 'boss_id', 'user_id');
    }
}
