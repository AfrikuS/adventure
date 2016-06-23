<?php

namespace App\Http\Controllers\Macro;

use App\Http\Controllers\MacroController;
use App\Http\Requests;
use App\Http\Requests\Process\EmploymentRequest;
use App\Models\Macro\Timer;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class ObtainController extends PoliticController
{
    public function index()
    {
        return $this->view('macro/obtain', [
        ]);
    }
    
    public function obtainFood (EmploymentRequest $request)
    {
        $user_id = auth()->user()->id;

        $peopleCount = $request->get('count');
        $timeSeconds = $request->get('time');
        $kind = $request->get('kind');

        try {
            DB::beginTransaction();

            $procTimer = new Timer();
            $procTimer->user_id = $user_id;
            $procTimer->people_count = $peopleCount;
            $procTimer->kind = $kind;
            $procTimer->date_time = Carbon::create()->addMinutes($timeSeconds)->toDateTimeString();
            $procTimer->created_at = Carbon::create()->toDateTimeString();
            $procTimer->save();

            DB::table('process_resources')->whereId($user_id)->decrement('free_people', $peopleCount);
//            Resources::find($user_id)->decrement('free_people', $peopleCount);

        }
        catch (Exception $e) {
            DB::rollback();
        }
        DB::commit();

        return redirect()->route('macro_obtain_page');
    }

}
