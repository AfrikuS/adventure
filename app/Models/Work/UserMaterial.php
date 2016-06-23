<?php

namespace App\Models\Work;

use Illuminate\Database\Eloquent\Model;

class UserMaterial extends Model
{
    protected $table      = 'work_user_materials';
    protected $primaryKey = 'id';
    public $timestamps    = false;
    protected $fillable   = ['user_id', 'code', 'value'];
}
