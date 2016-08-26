<?php

namespace App\Models\Drive;

use Illuminate\Database\Eloquent\Model;

class Raid extends Model
{
    protected $table      = 'drive_raids';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable   = ['id', 'vehicle_id', 'status', 'reward', 'start_raid',
                    'victim_id', 'robbery_status', ];

    public function driver()
    {
        return $this->hasOne(Driver::class, 'id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }

    public function victim()
    {
        return $this->belongsTo(Hero::class, 'victim_id', 'id');
    }
}
