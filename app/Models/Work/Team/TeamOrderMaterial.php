<?php

namespace App\Models\Work\Team;

use Illuminate\Database\Eloquent\Model;

class TeamOrderMaterial extends Model
{
    protected $table      = 'work_teamorder_materials';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['teamorder_id', 'code', 'need', 'stock'];

    public function teamOrder()
    {
        return $this->belongsTo('App\Models\Work\Team\TeamOrder');
    }

}
