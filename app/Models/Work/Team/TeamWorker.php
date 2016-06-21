<?php

namespace App\Models\Work\Team;

use App\Models\Work\UserInstrument;
use App\Models\Work\UserMaterial;
use App\Models\Work\WorkUserSkill;
use Illuminate\Database\Eloquent\Model;

class TeamWorker extends Model
{
    protected $table      = 'work_team_workers';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'team_id', 'status'];
    
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id');
    }

    public function team()
    {
        return $this->belongsTo('App\Models\Work\Team\PrivateTeam', 'team_id', 'id');
    }

    public function skills()
    {
        return $this->hasMany(WorkUserSkill::class, 'worker_id', 'id');
    }

    public function materials()
    {
        return $this->hasMany(UserMaterial::class, 'user_id', 'id');
    }

    public function instruments()
    {
        return $this->hasMany(UserInstrument::class, 'worker_id', 'id');
    }
}
