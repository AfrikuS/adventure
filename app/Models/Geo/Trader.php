<?php

namespace App\Models\Geo;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Trader extends Model
{
    protected $table      = 'geo_traders';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable   = ['id'];

    public function user()
    {
        return $this->hasOne(User::class, 'id');
    }
}
