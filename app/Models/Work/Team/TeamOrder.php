<?php

namespace App\Models\Work\Team;

use Illuminate\Database\Eloquent\Model;

class TeamOrder extends Model
{
    protected $table      = 'work_teamorders';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['desc', 'kind_work', 'price', 'acceptor_team_id', 'status'];

    public function materials()
    {
        return $this->hasMany('App\Models\Work\Team\TeamOrderMaterial', 'teamorder_id', 'id');
    }

    public function skills()
    {
        return $this->hasMany('App\Models\Work\Team\TeamOrderSkill', 'teamorder_id', 'id');
    }
    
    public function instruments()
    {
        return $this->hasMany(TeamOrderInstrument::class, 'teamorder_id', 'id');
    }
    
    public function team() 
    {
        return $this->belongsTo(PrivateTeam::class, 'acceptor_team_id', 'id');
    }

}
