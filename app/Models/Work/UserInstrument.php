<?php

namespace App\Models\Work;

use Illuminate\Database\Eloquent\Model;

class UserInstrument extends Model
{
    protected $table      = 'work_worker_instruments';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable   = ['worker_id', 'code', 'skill_level'];
}
