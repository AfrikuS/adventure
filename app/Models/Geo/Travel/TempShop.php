<?php

namespace App\Models\Geo\Travel;

use Illuminate\Database\Eloquent\Model;

class TempShop extends Model
{
    protected $table      = 'market_temp_shops';
    protected $primaryKey = 'id';
    public $timestamps    = false;
    public $fillable      = ['date_ending'];


}
