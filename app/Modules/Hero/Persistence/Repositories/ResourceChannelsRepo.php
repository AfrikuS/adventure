<?php

namespace App\Modules\Hero\Persistence\Repositories;

use App\Models\Auth\UserRedis;
use App\Modules\Auth\Persistence\Repositories\UsersRepo;
use App\Modules\Hero\Domain\Entities\Channel;
use App\Modules\Hero\Persistence\Dao\ResourceChannelsDao;

class ResourceChannelsRepo
{
    /** @var ResourceChannelsDao */
    private $channelsDao;
    
    /** @var UsersRepo */
    private $usersRepo;

    public function __construct(ResourceChannelsDao $channelsDao)
    {
        $this->channelsDao = $channelsDao;
    }

    public function getChannelsFromHero($hero_id)
    {
        $channelsData = $this->channelsDao->getChannelsFromHero($hero_id);

        $channels = [];

        foreach ($channelsData as $channelData) {
            $channel = new Channel($channelData);

//            $userFrom = $this->usersDao->find($channelData->from_user_id);
//            $userTo = $this->usersDao->find($channelData->to_user_id);
            $userFrom = UserRedis::getById($channelData->from_user_id);
            $userTo = UserRedis::getById($channelData->to_user_id);

            $channel->setFromUser($userFrom);
            $channel->setToUser($userTo);

            $channels[] = $channel;
        }

        return $channels;
    }

    public function getChannelsToHero($hero_id)
    {
        $channelsData = $this->channelsDao->getChannelsToHero($hero_id);

        $channels = [];

        foreach ($channelsData as $channelData) {
            $channel = new Channel($channelData);

//            $userFrom = $this->usersDao->find($channelData->from_user_id);
//            $userTo = $this->usersDao->find($channelData->to_user_id);
            $userFrom = UserRedis::getById($channelData->from_user_id);
            $userTo = UserRedis::getById($channelData->to_user_id);

            $channel->setFromUser($userFrom);
            $channel->setToUser($userTo);

            $channels[] = $channel;
        }

        return $channels;
    }
}
