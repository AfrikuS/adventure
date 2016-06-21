<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroThing extends Model
{
    protected $table      = 'hero_things';
    public    $timestamps = false;
    protected $fillable   = ['title', 'status', 'owner_id'];

    public function lock()
    {
        $this->update(['status' => 'lock']);
    }

    public function changeOwner($user_id)
    {
        
    }
}
