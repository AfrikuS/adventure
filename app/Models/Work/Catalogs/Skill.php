<?php

namespace App\Models\Work\Catalogs;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table      = 'work_catalog_skills';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['code', 'title'];

}
