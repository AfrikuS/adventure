<?php

namespace App\Models\Mine;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Miner extends Model
{
    protected $table      = 'mine_miners';
    public $timestamps    = false;
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'petrol', 'kerosene', 'oil', 'whater'];

    public function user()
    {
        return $this->hasOne(User::class, 'id');
    }
}
