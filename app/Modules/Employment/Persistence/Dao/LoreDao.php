<?php

namespace App\Modules\Employment\Persistence\Dao;

use App\Exceptions\Persistence\EntityNotFound_Exception;

class LoreDao
{
    private $table = 'employment_lore';

    public function findByUser($user_id, $code)
    {
        $lore = \DB::table($this->table)
            ->select(['id', 'user_id', 'mosaic', 'domain_id', 'size', 'domain_code'])
            ->where('user_id', $user_id)
//            ->where('domain_id', $domain_id)
            ->where('domain_code', $code)
            ->first();

        if (null === $lore) {
            throw new EntityNotFound_Exception;
        }

        return $lore;
    }

    public function getByUser($user_id)
    {
        $lore = \DB::table($this->table)
            ->select(['id', 'user_id', 'mosaic', 'domain_id', 'size', 'domain_code'])
            ->where('user_id', $user_id)
            ->get();

        return $lore;
    }

    public function find($code, $user_id)
    {
        $loreData = \DB::table($this->table)
            ->select(['id', 'user_id', 'mosaic', 'domain_id', 'size', 'domain_code'])
//            ->where('domain_id', $lore_id)
            ->where('domain_code', $code)
            ->where('user_id', $user_id)
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

    public function update($lore)
    {
        \DB::table($this->table)
            ->where('user_id', $lore->user_id)
//            ->where('domain_id', $lore->domain_id)
            ->update([
                'mosaic'  => $lore->mosaic,
            ]);
    }

    public function getDomainsIdsByUser($user_id)
    {
        $domainsCodes = \DB::table($this->table)
//            ->select(['domain_id'])
            ->where('user_id', $user_id)
            ->pluck('domain_code');

        return $domainsCodes;

//        return array_map(function ($item) {
//            return $item->domain_id;
//        }, $domains_ids);
    }
}
