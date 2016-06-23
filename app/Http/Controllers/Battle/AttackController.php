<?php

namespace App\Http\Controllers\Battle;

use App\Domain\Game\Fight;
use App\Domain\PlayersOperations;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\AttackRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class AttackController extends Controller
{
    public function searchPage()
    {
        $user_id = auth()->user()->id;
        
        /** @var  Collection $lastAttacks */
        $lastAttacks = AttackRepository::getLastAttacks($user_id);

        return $this->view('attack/search', [
            'attacks' => $lastAttacks,
        ]);
    }

    public function attack()
    {
        $atacker_id = auth()->user()->id;
        $defenser_id = Input::get('user_id');

        $moment = Carbon::now()->addMinutes(1)->addSeconds(8);

        $atacker = auth()->user();
        $defenser = User::select(['id', 'name'])->find($defenser_id);
        AttackRepository::insertAttackEvent($atacker_id, $defenser, $moment);
        
        PlayersOperations::addResourceChannel($atacker, $defenser);

        return $this->view('attack/attack_result', [
            'atacker' => $atacker,
            'defenser' => $defenser,
        ]);
    }

    public function searchOpponent()
    {
        $user_id = auth()->user()->id;
        $allUsers = User::select(['id'])->where('id', '<>', $user_id)->all();
        $atackedUsers_ids = AttackRepository::getAttackedIdsBy($user_id);
        $atackedUsers_ids = array_map(function($user) {
            return $user->defense_user_id;
        }, $atackedUsers_ids);

        // intersect
        $validUsers = array_diff($allUsers, $atackedUsers_ids);

        $validUsers_ids = array_values($validUsers);


        if (count($validUsers_ids) > 0) {

            $rand_id = rand(0, count($validUsers_ids) - 1);
            $defenser_id = $validUsers_ids [ $rand_id ];
            $user = User::find($defenser_id);
        }
        else {
            return redirect('/search');
        }


        return $this->view('attack/search_result', [
            'user' => $user,
            'users_ids' => $validUsers_ids,
        ]);
    }

    public function searchResult()
    {
//        if free_users_exist show user and button attack
//        else show search_page with message not free users
    }
}
