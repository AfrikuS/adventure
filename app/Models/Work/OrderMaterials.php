<?php

namespace App\Models\Work;

use Illuminate\Database\Eloquent\Model;

class OrderMaterials extends Model
{
    protected $table      = 'work_order_materials';
    protected $primaryKey = 'id';
    public $timestamps    = false;
    protected $fillable   = ['order_id', 'code', 'need', 'stock'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
