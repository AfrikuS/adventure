<?php

namespace App\Models\Work\Team;

use App\Models\Work\Order;
use App\Models\Work\Worker;
use Illuminate\Database\Eloquent\Model;

class PrivateTeam extends Model
{
    protected $table      = 'work_teams';
    protected $primaryKey = 'id';
    public $timestamps = false;
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
        return $this->hasMany(Order::class, 'acceptor_team_id', 'id');
    }
}
