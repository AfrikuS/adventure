<?php

namespace App\Models\Work;

use Illuminate\Database\Eloquent\Model;

class ShopMaterial extends Model
{
    protected $table      = 'work_shop_materials';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable   = ['price', 'code', 'material_id'];
}
