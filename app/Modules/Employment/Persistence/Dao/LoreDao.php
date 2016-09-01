<?php

namespace App\Modules\Employment\Persistence\Dao;

use App\Exceptions\Persistence\EntityNotFound_Exception;

class LoreDao
{
    private $table = 'employment_lore';

    public function getByUser($user_id)
    {
        $lores = \DB::table($this->table)
            ->select(['id', 'user_id', 'mosaic', 'domain_id', 'size', 'domain_code'])
            ->where('user_id', $user_id)
            ->get();

        return $lores;
    }

    public function find($id)
    {
        $loreData = \DB::table($this->table)
            ->select(['id', 'user_id', 'mosaic', 'domain_id', 'size', 'domain_code'])
            ->find($id);

        if (null === $loreData) {
            throw new EntityNotFound_Exception;
        }

        return $loreData;
    }

    public function findBy($user_id, $domain_id)
    {
        $loreData = \DB::table($this->table)
            ->select(['id', 'user_id', 'mosaic', 'domain_id', 'size', 'domain_code'])
            ->where('user_id', $user_id)
            ->where('domain_id', $domain_id)
            ->first();

        if (null === $loreData) {
            throw new EntityNotFound_Exception;
        }

        return $loreData;
    }

    public function create($user_id, $domain_id, $mosaic, $size)
    {
        $domain_id = \DB::table($this->table)->insert([
            'user_id' => $user_id,
            'domain_id' => $domain_id,
            'mosaic' => $mosaic,
            'size' => $size,
        ]);

        return $domain_id;
    }

    public function update($id, $mosaic)
    {
        \DB::table($this->table)
            ->where('id', $id)
            ->update([
                'mosaic'  => $mosaic,
            ]);
    }

    public function getDomainsIdsByUser($user_id)
    {
        $domains_ids = \DB::table($this->table)
            ->where('user_id', $user_id)
            ->pluck('domain_id');

        return $domains_ids;
    }
}
