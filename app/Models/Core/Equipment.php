<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table      = 'hero_equipment';

    protected $primaryKey = 'hero_id';

    public    $timestamps = false;

    protected $fillable   = [

            'hero_id',
            'pump_level',    'oil_distillator_level'
        
        ];

    public function hero ()
    {
        return $this->hasOne(Hero::class, 'hero_id', 'id');
    }
}
