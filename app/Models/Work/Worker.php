<?php

namespace App\Models\Work;

use App\Models\User;
use App\Models\Work\Team\PrivateTeam;
use App\Models\Work\Worker\WorkerInstrument;
use App\Models\Work\Worker\WorkerMaterial;
use App\Models\Work\Worker\WorkerSkill;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $table      = 'work_team_workers';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'team_id', 'status'];
    
    public function user()
    {
        return $this->hasOne(User::class, 'id');
    }

    public function team()
    {
        return $this->belongsTo(PrivateTeam::class, 'team_id', 'id');
    }

    public function skills()
    {
        return $this->hasMany(WorkerSkill::class, 'worker_id', 'id');
    }

    public function materials()
    {
        return $this->hasMany(WorkerMaterial::class, 'user_id', 'id');
    }

    public function instruments()
    {
        return $this->hasMany(WorkerInstrument::class, 'worker_id', 'id');
    }

    public function getMaterialByCode($code)
    {
        $materials = $this->materials != null ? $this->materials : $this->materials()->get(['id', 'code', 'value']);

        $index = $materials->search(function ($material, $key) use ($code) {
            return $material->code === $code;
        });

        if (is_int($index)) {
            return $materials->get($index); 
        }
        
        return null; 
    }

    public function getSkillByCode($code)
    {
        $skills = $this->skills != null ? $this->skills : $this->skills()->get(['id', 'code', 'value']);

        $index = $skills->search(function ($skill, $key) use ($code) {
            return $skill->code === $code;
        });

        if (is_int($index)) {
            return $skills->get($index);
        }

        return null;
    }
}
