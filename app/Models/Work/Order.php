<?php

namespace App\Models\Work;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table      = 'work_orders';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable   = ['desc', 'kind_work_title', 'price', 'acceptor_user_id', 'status' ];
    // statuses: created (in order_list) -> accepted (waiting_stock_materials) -> ready_to_work (after stocking materials)
    //            finished_success | finished_late  ||  over_timing  || cancelled

    public function materials() {
        return $this->belongsTo('App\Models\Work\OrderMaterials', 'order_id');
    }

}
