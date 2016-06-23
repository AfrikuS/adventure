<?php

namespace App\Models\Work;

use Illuminate\Database\Eloquent\Model;

class ShopInstrument extends Model
{
    protected $table      = 'work_shop_instruments';
    public $timestamps    = false;
    protected $primaryKey = 'id';
    protected $fillable   = ['price', 'code', 'instrument_id'];
}
