<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;

class Island extends Model
{
    protected $primaryKey = 'user_id';
    protected $table = 'geo_islands';
    public $timestamps = false;
    public $fillable = ['title', 'date_time'];//, 'user_id'];
}
