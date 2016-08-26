<?php

namespace App\Models\Drive;

use App\Models\Drive\Catalogs\DetailKind;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $table      = 'drive_details';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable  = ['title', 'kind_id', 'nominal_value', 'status', 'mount_status',
        'state_percent', 'owner_driver_id', 'vehicle_id'];

    public function kind()
    {
        return $this->belongsTo(DetailKind::class, 'kind_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(Driver::class, 'owner_driver_id', 'id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }
}
