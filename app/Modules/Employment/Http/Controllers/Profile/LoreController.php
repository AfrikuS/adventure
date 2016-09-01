<?php

namespace App\Modules\Employment\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Modules\Employment\Persistence\Repositories\LoreRepo;

class LoreController extends Controller
{
    public function index()
    {
        /** @var LoreRepo $loreRepo */
        $loreRepo = app('LoreRepo');
        $lores = $loreRepo->getBy($this->user_id);


        return $this->view('employment.profile.lores', [
            'lores' => $lores,
        ]);
    }

}
