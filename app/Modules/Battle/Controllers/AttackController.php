<?php

namespace App\Modules\Battle\Controllers;

use App\Modules\Core\Http\Controller;
use App\Http\Requests;
use App\Modules\Battle\Actions\AttackOpponentCommand;
use App\Modules\Battle\Domain\Services\SearchService;
use App\Modules\Battle\Persistence\Repository\AttacksRepo;
use Illuminate\Support\Facades\Input;

class AttackController extends Controller
{
    public function searchPage()
    {
        /** @var AttacksRepo $attacks */
        $attacks = app('AttacksRepo');

        
        $lastAttacks = $attacks->getLastAttacks($this->user_id);

        return $this->view('battle.attack.search', [
            'attacks' => $lastAttacks,
        ]);
    }

    public function attack()
    {
        $defenser_id = Input::get('user_id');
        $atacker_id = $this->user_id;


        $cmd = new AttackOpponentCommand();
        
        $cmd->attack($atacker_id, $defenser_id);


        $users = app('UsersRepo');


        $atacker = $users->find($atacker_id);
        $defenser = $users->find($defenser_id);

        return $this->view('battle.attack.attack_result', [
            'atacker' => $atacker,
            'defenser' => $defenser,
        ]);
    }

    public function searchOpponent()
    {
        $user_id = $this->user_id;

        
        $query = new SearchService();
            
        $opponent = $query->searchOpponentFor($user_id);
        

        if ($opponent === null) {

            \Session::flash('message', 'Противников не найдено!');
            return redirect('/search');
        }


        return $this->view('battle.attack.search_result', [
            'user' => $opponent,
        ]);
    }
}
