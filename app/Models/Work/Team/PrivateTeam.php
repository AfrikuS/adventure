<?php

namespace App\Models\Work\Team;

use Illuminate\Database\Eloquent\Model;

class PrivateTeam extends Model
{
    protected $table      = 'work_privateteams';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'leader_worker_id', 'kind_work', 'status'];

    public function leader() 
    {
        return $this->belongsTo(TeamWorker::class, 'leader_worker_id', 'id');
    }

    public function partners()
    {
        return $this->hasMany('App\Models\Work\Team\TeamWorker', 'team_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Work\Team\TeamOrder', 'acceptor_team_id', 'id');
    }


}
