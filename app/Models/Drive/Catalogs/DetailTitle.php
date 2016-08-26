<?php

namespace App\Models\Drive\Catalogs;

use Illuminate\Database\Eloquent\Model;

class DetailTitle extends Model
{
    protected $table      = 'drive_catalog_details_titles';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable   = ['kind_id', 'title'];

    public function kind()
    {
        return $this->belongsTo(DetailKind::class, 'kind_id');
    }
}
