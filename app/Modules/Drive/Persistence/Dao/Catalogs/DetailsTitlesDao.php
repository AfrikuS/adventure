<?php

namespace App\Modules\Drive\Persistence\Dao\Catalogs;

use App\Exceptions\Persistence\EntityNotFound_Exception;

class DetailsTitlesDao
{
    private $table = 'drive_catalog_details_titles';

    public function find($id)
    {
        $title =
            \DB::table($this->table)
                ->select(['id', 'title', 'kind_id'])
                ->find($id);

        if (null === $title) {

            throw new EntityNotFound_Exception;
        }

        return $title;
    }

    public function create($title, $kind_id)
    {
        $title_id =
            \DB::table($this->table)->insertGetId([
                'title' => $title,
                'kind_id' => $kind_id,
            ]);

        return $title_id;
    }

    public function get()
    {
        $titles =
            \DB::table($this->table)
                ->select(['id', 'title', 'kind_id'])
                ->get();

        return $titles;
    }

}
