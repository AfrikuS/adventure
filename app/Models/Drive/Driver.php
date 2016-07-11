<?php

namespace App\Models\Drive;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table      = 'drive_drivers';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable   = ['id'];

    public function user()
    {
        return $this->hasOne(User::class, 'id');
    }
}
