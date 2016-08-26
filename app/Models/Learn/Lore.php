<?php

namespace App\Models\Learn;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Lore extends Model
{
    protected $table      = 'learning_lore';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    protected $fillable   = ['user_id', 'mosaic', 'amount'];


    
    public function user()
    {
        return $this->hasOne(User::class, 'id');
    }

    public function addKnowledge($frame)
    {
        $mosaic = $this->mosaic;
        $mosaic[$frame] = '1';

        $this->mosaic = $mosaic;
        $this->amount++;

//        ->update(['delayed' => 1]);
    }

    public function restoreDefault()
    {
        $this->mosaic = '000000000000000000000';
        $this->amount = 0;
    }

}
