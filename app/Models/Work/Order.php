<?php

namespace App\Models\Work;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table      = 'work_orders';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable   = ['desc', 'kind_work_title', 'price', 'acceptor_user_id', 'status' ];

    public function materials() 
    {
        return $this->hasMany(OrderMaterials::class, 'order_id');
    }
    

//    public function isAcceptedBy(Worker $worker)
//    {
//        return $this->acceptor_user_id && ($this->acceptor_user_id == $worker->id);
//    }


}
