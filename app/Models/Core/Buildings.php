<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Buildings extends Model
{
    protected $table      = 'hero_buildings';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['id', 'gates_level', 'fence_level', 'door_house_level',
                               'door_ambar_level', 'door_resource_warehause_level'];
    
    public function hero ()
    {
        return $this->hasOne(Hero::class, 'id');
    }
}
