<?php

namespace App\Models;

use App\Concerns\Auth\AppAuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['name', 'password', 'email'];

    use AppAuthenticatableTrait;

    public function boss()
    {
        return $this->belongsToMany('App\Models\Mass\Boss', 'mass_boss_users_rels',
            'user_id', 'boss_id');
    }
    
    public function resources()
    {
        return $this->hasOne('App\Models\HeroResources', 'id', 'id');
    }

    public function worker()
    {
        return $this->belongsTo('App\Models\Work\Team', 'id');
    }

    public function buildings()
    {
        return $this->hasMany('App\Models\Macro\Building', 'user_id', 'id');
    }

    public function plusChannels()
    {
        return $this->hasMany('App\Models\ResourceChannel', 'to_user_id', 'id');
    }

    public function lossChannels()
    {
        return $this->hasMany('App\Models\ResourceChannel', 'from_user_id', 'id');
    }
}
