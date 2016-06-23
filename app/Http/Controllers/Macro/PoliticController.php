<?php

namespace App\Http\Controllers\Macro;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Macro\Building;
use App\Repositories\Macro\ProcessRepository;

class PoliticController extends Controller
{
    public function index ()
    {
        $user_id = auth()->user()->id;
        $employments = ProcessRepository::activeEmployments($user_id);
        $buildings = Building::
            select(['user_id', 'kind', 'count'])
            ->where('user_id', '=', $user_id)
            ->get();

        return $this->view('macro/index', [
            'employments' => $employments,
            'buildings' => $buildings,
        ]);
    }
    

    public function learnProfession()
    {
        return redirect()->route('macro_page');
    }

//    public function view($view = null, $data = [])
//    {
//
//        $res = Resources::find(auth()->user()->id);
//
//        return view($view, $data, [
//            'resources' => $res,
//        ]);
//    }
}
