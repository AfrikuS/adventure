<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $table      = 'actions';
    public    $timestamps = false;
    protected $fillable   = ['title', 'code', 'duration_seconds'];

}
