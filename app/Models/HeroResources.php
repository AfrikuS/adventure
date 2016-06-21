<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroResources extends Model
{
    protected $table      = 'hero_resources';
    public    $timestamps = false;
    protected $fillable   = ['id'];

    public static function init()
    {
        $users = User::find([9,10,12,13,14]);
        foreach ($users as $user) {
            HeroResources::create(['id' => $user->id]);
        }
    }

    public function user ()
    {
        return $this->belongsTo('App\Models\User', 'id');
    }
}
