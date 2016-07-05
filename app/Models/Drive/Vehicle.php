<?php

namespace App\Models\Drive;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table      = 'drive_vehicles';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable   = ['driver_id', 'acceleration', 'stability', 'mobility'];

    public function driver()
    {
        return $this->hasOne(Driver::class, 'id');
    }
}
