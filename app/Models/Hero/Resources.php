<?php

namespace App\Models\Hero;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    protected $table      = 'hero_resources';
    public    $timestamps = false;
    protected $fillable   = ['id'];

    public static function init()
    {
        $users = User::find([9,10,12,13,14]);
        foreach ($users as $user) {
            Resources::create(['id' => $user->id]);
        }
    }

    public function user ()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
