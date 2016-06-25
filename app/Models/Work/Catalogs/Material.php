<?php

namespace App\Models\Work\Catalogs;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table      = 'work_catalog_materials';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['code', 'title'];

}
