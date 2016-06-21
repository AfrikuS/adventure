<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\ProfileController;
use App\Models\ResourceChannel;
use Illuminate\Http\Request;

use App\Http\Requests;

class ResourceChannelsController extends ProfileController
{
    public function index()
    {
        $user_id = auth()->user()->id;

        $channels = ResourceChannel::
            select(['id', 'from_user_id', 'to_user_id', 'resource', 'tax_percent'])
            ->where('to_user_id', $user_id)
            ->with(['fromUser' => function ($query) {
                $query->select('id', 'name'); // require ID !!!
            }])->get();

        $lossChannels = ResourceChannel::
            select(['id', 'from_user_id', 'to_user_id', 'resource', 'tax_percent'])
            ->where('from_user_id', $user_id)
            ->with(['toUser' => function ($query) {
                $query->select('id', 'name');
            }])->get();
        
        return $this->view('profile/channels', [
            'channels' => $channels,
            'lossChannels' => $lossChannels,
        ]);
    }
}
