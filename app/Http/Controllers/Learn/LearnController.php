<?php

namespace App\Http\Controllers\Learn;

use App\Commands\Learn\LearnAttemptCmd;
use App\Http\Controllers\Controller;
use App\Models\Learn\Lore;
use App\Repositories\Learn\LoreRepo;
use Illuminate\Support\Facades\Session;

class LearnController extends Controller
{
    public function index()
    {
        $loreRepo = new LoreRepo();

        $lore = Lore::find($this->user_id);
        
        if (null == $lore) {
            $lore = $loreRepo->create($this->user_id); 
        }
        
//        $lastAttacks = AttackRepository::getLastAttacks($this->user_id);

        return $this->view('learn.index', [
            'mosaic' => $lore->mosaic,
            'amount' => $lore->amount,
        ]);
    }

    public function learn()
    {
        

        $tryLearnCmd = new LearnAttemptCmd();

        $tryLearnCmd->attempt('building', $this->user_id);

        
        
        return \Redirect::route('learn_page');
    }

    public function restoreDefault()
    {
        $lore = Lore::find($this->user_id);

        $lore->restoreDefault();

        $lore->save();


        return \Redirect::route('learn_page');
    }
}
