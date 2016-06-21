<?php

namespace App\Models\Work;

use Illuminate\Database\Eloquent\Model;

class OrderMaterials extends Model
{
    protected $table      = 'work_order_materials';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable   = ['order_id', 'code', 'need', 'stock'];

    public function order()
    {
        return $this->hasOne('App\Models\Work\Order', 'id', 'order_id');
    }

}
