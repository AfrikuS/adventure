<?php

namespace App\Modules\Hero\Persistence\Dao;

use App\Exceptions\Persistence\EntityNotFound_Exception;

class ResourceChannelsDao
{
    private $table = 'hero_resource_channels';

    public function find($channel_id)
    {
        $channelData =
            \DB::table($this->table)
                ->select(['id', 'from_user_id', 'to_user_id', 'resource', 'tax_percent'])
                ->find($channel_id);

        if (null === $channelData) {
            throw new EntityNotFound_Exception;
        }

        return $channelData;
    }

    public function create($from_user_id, $to_user_id, $resource, $tax)
    {
        $channel_id =
            \DB::table($this->table)->insertGetId([
                'from_user_id' => $from_user_id,
                'to_user_id' => $to_user_id,
                'resource' => $resource,
                'tax_percent' => $tax,
            ]);

        return $channel_id;
    }
    
    public function findByOwner($hero_id, $to_user_id)
    {
        $channelData =
            \DB::table($this->table)
                ->select(['id', 'from_user_id', 'to_user_id', 'resource', 'tax_percent'])
                ->where('from_user_id', $hero_id)
                ->where('to_user_id', $to_user_id)
                ->first();
        
        if (null === $channelData) {
            throw new EntityNotFound_Exception;
        }

        return $channelData;
    }
    
    public function getChannelsFromHero($hero_id)
    {
        $channelsData =
            \DB::table($this->table)
                ->select(['id', 'from_user_id', 'to_user_id', 'resource', 'tax_percent'])
                ->where('from_user_id', $hero_id)
                ->get();

        return $channelsData;
    }

    public function getChannelsToHero($hero_id)
    {
        $channelsData =
            \DB::table($this->table)
                ->select(['id', 'from_user_id', 'to_user_id', 'resource', 'tax_percent'])
                ->where('to_user_id', $hero_id)
                ->get();

        return $channelsData;
    }
}
