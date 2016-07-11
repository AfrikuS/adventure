<?php

namespace App\Models\Drive\Catalogs;

use Illuminate\Database\Eloquent\Model;

class DetailKind extends Model
{
    protected $table      = 'drive_catalog_detail_kinds';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable   = ['title'];

}
