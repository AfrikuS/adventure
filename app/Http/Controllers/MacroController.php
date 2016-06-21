<?php

namespace App\Http\Controllers;

use App\Http\Requests\Process\BuildRequest;
use App\Http\Requests\Process\EmploymentRequest;
use App\Models\Macro\Building;
use App\Models\Macro\Resources;
use App\Models\Macro\Timer;
use App\Repositories\Macro\ProcessRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class MacroController extends Controller
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
