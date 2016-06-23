<?php

namespace App\Models\Work;

use Illuminate\Database\Eloquent\Model;

class ShopMaterial extends Model
{
    protected $table      = 'work_shop_materials';
    protected $primaryKey = 'id';
    public $timestamps    = false;
    protected $fillable   = ['price', 'code', 'material_id'];
}
