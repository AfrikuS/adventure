<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Battle\ResourceChannel;
use App\Repositories\Work\SkillRepository;

class ProfileController extends Controller
{
    public function index()
    {
        $userSkills = SkillRepository::getUserSkills(auth()->user());

        return $this->view('profile.profile', [
            'skills' => $userSkills
        ]);
    }

    public function channels()
    {
        $user_id = \Auth::id();

        $channels = ResourceChannel::
            select(['id', 'from_user_id', 'to_user_id', 'resource', 'tax_percent'])
            ->where('to_user_id', $user_id)
            ->with(['fromUser' => function ($query) {
                $query->select('id', 'name');
            }])->get();

        $lossChannels = ResourceChannel::
            select(['id', 'from_user_id', 'to_user_id', 'resource', 'tax_percent'])
            ->where('from_user_id', $user_id)
            ->with(['toUser' => function ($query) {
                $query->select('id', 'name');
            }])->get();

        return $this->view('profile.channels', [
            'channels' => $channels,
            'lossChannels' => $lossChannels,
        ]);
    }
}
