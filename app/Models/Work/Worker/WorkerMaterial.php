<?php

namespace App\Models\Work\Worker;

use Illuminate\Database\Eloquent\Model;

class WorkerMaterial extends Model
{
    protected $table      = 'work_worker_materials';
    protected $primaryKey = 'id';
    public $timestamps    = false;
    protected $fillable   = ['user_id', 'code', 'value'];
}
