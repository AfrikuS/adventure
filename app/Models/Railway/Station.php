<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $table      = 'railway_stations';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['id', 'level', 'status'];
}
