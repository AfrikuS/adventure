<?php

namespace App\Http\Controllers\Battle;

use App\Commands\Battle\AttackOpponentCommand;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Queries\Battle\SearchOpponentQuery;
use App\Repositories\AttackRepository;
use App\Repositories\Battle\TeaserRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class AttackController extends Controller
{
    /** @var TeaserRepository */
    private $teaserRepo;

    public function __construct(TeaserRepository $teaserRepo)
    {
        parent::__construct();

        $this->teaserRepo = $teaserRepo;
    }

    public function searchPage()
    {
//        $user_id = \Auth::id();
        
        /** @var  Collection $lastAttacks */
        $lastAttacks = AttackRepository::getLastAttacks($this->user_id);

        return $this->view('battle.attack.search', [
            'attacks' => $lastAttacks,
        ]);
    }

    public function attack()
    {
        $defenser_id = Input::get('user_id');
        $atacker_id = $this->user_id;


        $cmd = new AttackOpponentCommand(new TeaserRepository());
        
        $cmd->attack($atacker_id, $defenser_id);



        $atacker  = User::find($atacker_id);
        $defenser = User::select('id', 'name')->find($defenser_id);

        return $this->view('battle.attack.attack_result', [
            'atacker' => $atacker,
            'defenser' => $defenser,
        ]);
    }

    public function searchOpponent()
    {
        $user_id = $this->user_id;

        
        $query = new SearchOpponentQuery(new TeaserRepository());
            
        $opponents_ids = $query->searchOpponent($user_id);
        


        if (count($opponents_ids) > 0) {

            $rand_id = rand(0, count($opponents_ids) - 1);
            $defenser_id = $opponents_ids [ $rand_id ];
            $user = User::find($defenser_id);
        }
        else {
            \Session::flash('message', 'Противников не найдено!');
            return redirect('/search');
        }


        return $this->view('battle.attack.search_result', [
            'user' => $user,
            'users_ids' => $opponents_ids,
        ]);
    }

    public function searchResult()
    {
//        if free_users_exist show user and button attack
//        else show search_page with message not free users
    }
}
