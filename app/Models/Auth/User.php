<?php

namespace App\Models\Auth;

use App\Models\Battle\Boss;
use App\Models\Battle\ResourceChannel;
use App\Models\Macro\Building;
use App\Models\Work\Worker;
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
        return $this->belongsToMany(Boss::class, 'mass_boss_users_rels',
            'user_id', 'boss_id');
    }
    
    public function resources()
    {
        return $this->hasOne(Resources::class, 'id', 'id');
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class, 'id');
    }

    public function buildings()
    {
        return $this->hasMany(Building::class, 'user_id', 'id');
    }

    public function plusChannels()
    {
        return $this->hasMany(ResourceChannel::class, 'to_user_id', 'id');
    }

    public function lossChannels()
    {
        return $this->hasMany(ResourceChannel::class, 'from_user_id', 'id');
    }
}
