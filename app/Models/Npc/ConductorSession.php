<?php

namespace App\Models\Npc;

use App\Models\Core\Hero;
use App\Models\Railway\TransitTrain;
use Illuminate\Database\Eloquent\Model;

class ConductorSession extends Model
{
    protected $table = 'npc_conductor_sessions';
    protected $primaryKey = 'hero_id';
    public $timestamps = false;
    protected $fillable = ['hero_id', 'conductor_id', 'train_id', 'mood', 'end_time'];

    public function hero()
    {
        return $this->hasOne(Hero::class, 'hero_id', 'id');
    }

    public function conductor()
    {
        return $this->belongsTo(Character::class, 'conductor_id', 'id');
    }

    public function train()
    {
        return $this->belongsTo(TransitTrain::class, 'train_id', 'id');
    }

}