<?php

namespace App\Models\Work;

use Illuminate\Database\Eloquent\Model;

class WorkUserSkill extends Model
{
    protected $table      = 'work_worker_skills';
    protected $primaryKey = 'id';
    public $timestamps    = false;
    protected $fillable   = ['worker_id', 'code', 'value'];

}
