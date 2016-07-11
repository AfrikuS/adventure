<?php

namespace App\Models\Drive;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table      = 'drive_vehicles';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable   = ['driver_id', 'acceleration', 'stability', 'mobility'];

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(Detail::class, 'vehicle_id', 'id');
    }
}
