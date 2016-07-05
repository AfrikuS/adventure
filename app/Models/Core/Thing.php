<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Thing extends Model
{
    protected $table      = 'hero_things';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['title', 'status', 'owner_id'];

}
