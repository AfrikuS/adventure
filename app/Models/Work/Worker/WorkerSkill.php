<?php

namespace App\Models\Work\Worker;

use Illuminate\Database\Eloquent\Model;

class WorkerSkill extends Model
{
    protected $table      = 'work_worker_skills';
    protected $primaryKey = 'id';
    public $timestamps    = false;
    protected $fillable   = ['worker_id', 'code', 'value'];

}
