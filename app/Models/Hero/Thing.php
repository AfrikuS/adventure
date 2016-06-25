<?php

namespace App\Models\Hero;

use Illuminate\Database\Eloquent\Model;

class Thing extends Model
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
