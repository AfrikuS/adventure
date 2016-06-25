<?php

namespace App\Models\Battle;

use Illuminate\Database\Eloquent\Model;

class ResourceChannel extends Model
{
    protected $table      = 'hero_resource_channels';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['from_user_id', 'to_user_id', 'resource', 'tax_percent'];

    public function fromUser()
    {
        return $this->belongsTo('App\Models\User', 'from_user_id');
    }
    
    public function toUser()
    {
        return $this->belongsTo('App\Models\User', 'to_user_id');
    }
}
