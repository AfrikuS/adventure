<?php

namespace App\Models\Geo\Travel;

use Illuminate\Database\Eloquent\Model;

class MaterialPrice extends Model
{
    protected $table      = 'travel_materials_prices';
    protected $primaryKey = 'id';
    public $timestamps    = false;
    public $fillable      = ['shop_id', 'code', 'material_id', 'price'];
}
