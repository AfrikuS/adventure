<?php

namespace App\Models\Work;

use Illuminate\Database\Eloquent\Model;

class UserInstrument extends Model
{
    protected $table      = 'work_worker_instruments';
    protected $primaryKey = 'id';
    public $timestamps    = false;
    protected $fillable   = ['worker_id', 'code', 'skill_level'];
}
