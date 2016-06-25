<?php

namespace App\Models\Work\Catalogs;

use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    protected $table      = 'work_catalog_instruments';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['code', 'title'];
}
