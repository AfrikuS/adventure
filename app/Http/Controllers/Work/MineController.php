<?php

namespace App\Http\Controllers\Work;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Work\Skills;
use App\Models\Work\Team\TeamworkOffer;
use App\Repositories\TeamworkRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class MineController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;

        $offers = TeamworkOffer::with('leader')
            ->select('id', 'kind_work', 'users_count', 'leader_user_id')
            ->with(['leader' => function ($query) {
                $query->select('id', 'name');
            }])
            ->get();

//        Session::flash('message', 'Lot is bought yet!');
//        Session::put('errors', [10,22,31]);

        return $this->view('work/mine', [
            'offers' => $offers,
        ]);
    }

    public function mine()
    {
        $user_id = auth()->id;
        $skills = Skills::find($user_id);

        if (null == $skills) {
            $skills = new Skills();
            $skills->user_id = $user_id;
        }
        $skills->mine_skill_level += 1;
        $skills->mines_total += 1;
        $skills->single_works_times += 1;
        $skills->save();

        return Redirect::route('work_mine_page', []);
    }

    public function createSingleTeamWork()
    {
        return $this->view('work/team/create_teamwork', [
        ]);
    }

    public function teamWorkConditions($offer_id)
    {
        $offer = TeamworkOffer::
            with(['leader' => function ($query) {
                $query->select('id', 'name');
            }])
            ->find($offer_id);

        return $this->view('work/team/team_work_conditions', [
            'offer' => $offer,
        ]);
    }

    public function createTeamWork()
    {
        $count = Input::get('count');
        $leader = auth()->user();

        TeamworkRepository::createTeamworkOffer($leader, $count);

        Session::flash('message', 'Team work was created!');
        return Redirect::route('work_mine_page', []);
    }

    public function joinToTeamWork()
    {
        $data = Input::all();
        $user = auth()->user();
        
        $offer = TeamworkOffer::
            select('id') //, 'kind_work', 'users_count', 'leader_user_id')
            ->with(['partners' => function ($query) {
                $query->select('id');
            }])
            ->find('id');

        $offer->partners()->save($user);

        Session::flash('message', 'You are joined to team!');
        return Redirect::route('work_mine_page', []);
    }

    public function teamWorkDelete()
    {
        $offer_id = Input::get('offer_id');

        $offer = TeamworkOffer::
            select('id')
            ->with(['partners' => function ($query) {
                $query->select('id');
            }])
            ->find($offer_id);

        DB::transaction(function () use ($offer) {
            $offer->partners()->detach();
            $offer->delete();
        });
        
        return Redirect::route('work_mine_page', []);
    }
}
