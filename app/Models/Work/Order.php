<?php

namespace App\Models\Work;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table      = 'work_orders';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable   = ['desc', 'type', 'status', 'kind_work_title', 'price',
        'acceptor_worker_id', 'acceptor_team_id'];

    public function materials()
    {
        return $this->hasMany(OrderMaterials::class, 'order_id');
    }

    public function skills()
    {
        return $this->hasMany(OrderSkill::class, 'order_id', 'id');
    }

//    public function instruments()
//    {
//        return $this->hasMany(TeamOrderInstrument::class, 'order_id', 'id');
//    }

//    public function isAcceptedBy(Worker $worker)
//    {
//        return $this->acceptor_user_id && ($this->acceptor_user_id == $worker->id);
//    }


}
