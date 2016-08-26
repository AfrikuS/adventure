<?php

namespace App\Models\Work\Team;

use Illuminate\Database\Eloquent\Model;

class TeamRewardPie extends Model
{
    protected $table      = 'work_team_reward_pies';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable   = ['worker_id', 'team_id', 'amount_percent'];
}
