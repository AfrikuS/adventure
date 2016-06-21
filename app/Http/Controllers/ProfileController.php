<?php

namespace App\Http\Controllers;

use App\Models\HeroResources;
use App\Models\Macro\Resources;
use App\Models\ResourceChannel;
use App\Repositories\Work\SkillRepository;
use Illuminate\Http\Request;

use App\Http\Requests;

class ProfileController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;

        $userSkills = SkillRepository::getUserSkills(auth()->user());

        return $this->view('profile/profile', [
            'skills' => $userSkills
        ]);
    }
}
