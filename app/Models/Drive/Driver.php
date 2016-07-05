<?php

namespace App\Models\Drive;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table      = 'drive_drivers';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable   = ['id'];

    public function user()
    {
        return $this->hasOne(User::class, 'id');
    }
}
