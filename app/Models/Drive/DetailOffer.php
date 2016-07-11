<?php

namespace App\Models\Drive;

use App\Models\Drive\Catalogs\DetailKind;
use Illuminate\Database\Eloquent\Model;

class DetailOffer extends Model
{
    protected $table      = 'drive_detail_offers';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable  = ['title', 'kind_id', 'nominal_value', 'driver_id'];

    public function kind()
    {
        return $this->belongsTo(DetailKind::class, 'kind_id', 'id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }
}
