<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class ResourceStore extends Model
{
    protected $table      = 'hero_resource_store';

    protected $primaryKey = 'hero_id';

    public    $timestamps = false;

    protected $fillable   = [

            'hero_id',
            'oil_capacity_level',    'oil_capacity_amount',    'oil_amount',
            'petrol_capacity_level', 'petrol_capacity_amount', 'petrol_amount',
            'water_capacity_level',  'water_capacity_amount',  'water_amount',
        
        ];

    public function hero ()
    {
        return $this->hasOne(Hero::class, 'hero_id', 'id');
    }
}
