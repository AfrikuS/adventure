<?php

namespace App\Models\Work;

use App\Factories\WorkerFactory;
use App\Models\Auth\User;
use App\Models\Work\Team\PrivateTeam;
use App\Models\Work\Worker\WorkerInstrument;
use App\Models\Work\Worker\WorkerMaterial;
use App\Models\Work\Worker\WorkerSkill;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $table      = 'work_workers';
    protected $primaryKey = 'id';
    public $timestamps = false;
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

    public function getMaterialByCode($code): WorkerMaterial
    {
        $materials = $this->materials != null ? $this->materials : $this->materials()->get(['id', 'code', 'value']);

        $index = $materials->search(function ($material, $key) use ($code) {
            return $material->code === $code;
        });

        return is_int($index)
            ? $materials->get($index)
            : WorkerFactory::createWorkerMaterial($this, $code);
    }

    public function getInstrumentByCode($code)
    {
        $instruments = $this->instruments != null ? $this->instruments : $this->instruments()->get(['id', 'code', 'skill_level']);

        $index = $instruments->search(function ($material, $key) use ($code) {
            return $material->code === $code;
        });

        return is_int($index)
            ? $instruments->get($index)
            : WorkerFactory::createWorkerInstrument($this, $code);
    }

    public function getSkillByCode($code)
    {
        $skills = $this->skills != null ? $this->skills : $this->skills()->get(['id', 'code', 'value']);

        $index = $skills->search(function ($skill, $key) use ($code) {
            return $skill->code === $code;
        });

        return is_int($index)
            ? $skills->get($index)
            : WorkerFactory::createWorkerSkill($this, $code);
    }
}
