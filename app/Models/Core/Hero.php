<?php

namespace App\Models\Core;

use App\Exceptions\DefecitHeroResException;
use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $table      = 'hero_resources';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['id', 'gold', 'oil', 'water'];

    public static function init()
    {
        $users = User::find([9,10,12,13,14]);
        foreach ($users as $user) {
            Hero::create(['id' => $user->id]);
        }
    }

    public function user ()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function things()
    {
        return $this->hasMany(Thing::class, 'owner_id', 'id');
    }

}
