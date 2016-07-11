<?php

namespace App\Models\Work;

use Illuminate\Database\Eloquent\Model;

class OrderSkill extends Model
{
    protected $table      = 'work_order_skills';
    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['order_id', 'code', 'need_times', 'stock_times'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
