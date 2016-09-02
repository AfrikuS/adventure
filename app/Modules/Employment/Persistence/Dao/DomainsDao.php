<?php

namespace App\Modules\Employment\Persistence\Dao;

use App\Exceptions\Persistence\EntityNotFound_Exception;

class DomainsDao
{
    private $table = 'employment_domains';

    public function find($id)
    {
        $domain = \DB::table($this->table)
            ->select(['id', 'code', 'title', 'mosaic_size'])
            ->find($id);

        return $domain;
    }

    public function getAll()
    {
        $domains = \DB::table($this->table)
            ->select(['id', 'code', 'title', 'mosaic_size'])
            ->get();

        if (null == $domains) {
            throw new EntityNotFound_Exception('no entries in ' . $this->table . ' table');
        }

        return $domains;
    }

    public function create($title, $code, $mosaicSize)
    {
        $domain_id =
            \DB::table($this->table)->insertGetId([
                'title' => $title,
                'code' => $code,
                'mosaic_size' => $mosaicSize,
        ]);

        return $domain_id;
    }

    public function findByCode($code)
    {
        $domain = \DB::table($this->table)
            ->select(['id', 'code', 'title', 'mosaic_size'])
            ->where('code', $code)
            ->first();

        if (null == $domain) {
            throw new EntityNotFound_Exception;
        }

        return $domain;
    }


    public function getDiffsUserDomains($userDomains_ids)
    {
        $domains = \DB::table($this->table)
            ->select(['id', 'code', 'title', 'mosaic_size'])
            ->whereNotIn('id', $userDomains_ids)
            ->get();

        return $domains;
    }

    public function getByIds($domains_ids)
    {
        $domains = \DB::table($this->table)
            ->select(['id', 'code', 'title', 'mosaic_size'])
            ->whereIn('id', $domains_ids)
            ->get();

        return $domains;
    }

    public function getLoreLicenses($user_id)
    {
        $licensesData =
            \DB::table($this->table.' AS do')
                ->select(['do.id AS domain_id', 'do.title AS domain_title', 'lo.user_id AS is_exist'])
                ->leftJoin('employment_lore AS lo', function ($join) use ($user_id) {
                    $join->on('lo.domain_id', '=', 'do.id')
                        ->where('lo.user_id', '=', $user_id);
                    })
                ->get();
        
        return $licensesData;
    }

}
