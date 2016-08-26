<?php

namespace App\Models\Railway;

use App\Models\Core\Hero;
use Illuminate\Database\Eloquent\Model;

class StationLicense extends Model
{
    protected $table      = 'railway_station_licenses';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['id', 'level', 'status', 'end_time'];

    public function hero()
    {
        return $this->hasOne(Hero::class, 'id');
    }
}
