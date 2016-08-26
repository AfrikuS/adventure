<?php

namespace App\Models\Npc;

use App\Models\Core\Hero;
use Illuminate\Database\Eloquent\Model;

class HeroConductorRelation extends Model
{
    protected $table      = 'npc_conductors_heroes_relations';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable   = ['hero_id', 'conductor_npc_id', 'respect_level',
        'drain_oil_price', 'drain_petrol_price'];

    public function hero()
    {
        return $this->belongsTo(Hero::class, 'hero_id', 'id');
    }

    public function conductor()
    {
        return $this->belongsTo(Character::class, 'conductor_npc_id', 'id');
    }
}
