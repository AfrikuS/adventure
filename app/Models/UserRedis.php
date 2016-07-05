<?php

namespace App\Models;

use App\Concerns\Auth\AppAuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class UserRedis implements Authenticatable
{
    protected $fillable   = ['name', 'password', 'email'];

    use AppAuthenticatableTrait;

    public static function save($userDb)
    {
//        $userDb = auth()->user();
        $user = static::getByName($userDb['name']);

        Redis::hmset('users:' . $user->id, [
            'id' => $user->id,
            'name' => $userDb['name'],
            'password' => '123',
        ]);

        Redis::hmset('users:' . $userDb['name'], [
            'id' => $user->id,
            'name' => $userDb['name'],
            'password' => '123',
        ]);
    }

    public static function getById($id)
    {
        $userHash = Redis::hgetall('users:' . $id);

        if (count($userHash) == 0)  return null;

        $user = new self();
        $user->id = $id;
        $user->name = $userHash['name'];
        $user->password = $userHash['password'];
        return $user;
    }
    
    public static function getByName($name)
    {
        $userHash = Redis::hgetall('users:' . $name);

        if (count($userHash) == 0)  return null;

        $user = new self();
        $user->id = $userHash['id'];
        $user->name = $name;
        $user->password = $userHash['password'];
        return $user;
    }
}
