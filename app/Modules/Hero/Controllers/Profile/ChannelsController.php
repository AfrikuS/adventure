<?php

namespace App\Modules\Hero\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Modules\Hero\Persistence\Repositories\ResourceChannelsRepo;

class ChannelsController extends Controller
{
    public function index()
    {
        /** @var ResourceChannelsRepo $channels */
        $channels = app('ResourceChannelsRepo');
        
        $user_id = $this->user_id;

        $plusChannels = $channels->getChannelsToHero($user_id);
        $lossChannels = $channels->getChannelsFromHero($user_id);

        return $this->view('profile.channels', [
            'channels' => $plusChannels,
            'lossChannels' => $lossChannels,
        ]);
    }
}
