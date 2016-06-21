<?php

namespace App\Models\Macro;

use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    protected $table      = 'macro_resources';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['*'];
}
