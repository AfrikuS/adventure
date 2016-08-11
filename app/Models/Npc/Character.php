<?php

namespace App\Models\Npc;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $table      = 'npc_characters';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable   = ['name'];
}
