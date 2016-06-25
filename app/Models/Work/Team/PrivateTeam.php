<?php

namespace App\Models\Work\Team;

use App\Models\Work\Worker;
use Illuminate\Database\Eloquent\Model;

class PrivateTeam extends Model
{
    protected $table      = 'work_privateteams';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'leader_worker_id', 'kind_work', 'status'];

    public function leader() 
    {
        return $this->belongsTo(Worker::class, 'leader_worker_id', 'id');
    }

    public function partners()
    {
        return $this->hasMany(Worker::class, 'team_id');
    }

    public function orders()
    {
        return $this->hasMany(TeamOrder::class, 'acceptor_team_id', 'id');
    }


}
