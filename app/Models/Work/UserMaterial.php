<?php

namespace App\Models\Work;

use Illuminate\Database\Eloquent\Model;

class UserMaterial extends Model
{
    protected $table      = 'work_user_materials';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable   = ['user_id', 'code', 'value'];
}
