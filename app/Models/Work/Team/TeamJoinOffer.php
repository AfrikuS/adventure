<?php

namespace App\Models\Work\Team;

use App\Models\Auth\User;
use App\Models\Work\Worker;
use Illuminate\Database\Eloquent\Model;

class TeamJoinOffer extends Model
{
    protected $table      = 'work_team_joinoffers';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable   = ['id', 'worker_id', 'team_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'worker_id', 'id');
    }
}
