<?php

namespace App\Models\Work\Team;

use Illuminate\Database\Eloquent\Model;

class TeamOrderSkill extends Model
{
    protected $table      = 'work_teamorder_skills';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['teamorder_id', 'code', 'need_times', 'stock_times'];

    public function teamOrder()
    {
        return $this->belongsTo('App\Models\Work\Team\TeamOrder');
    }
}
