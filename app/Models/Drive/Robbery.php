<?php

namespace App\Models\Drive;

use App\Models\Core\Hero;
use Illuminate\Database\Eloquent\Model;

/** @deprecated  */
class Robbery extends Model
{
    protected $table      = 'driver_robberies';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable   = ['id', 'vehicle_id', 'victim_id', 'status', 'start_robbery'];
    
    
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
