<?php

namespace App\Http\Controllers\Work;

use App\Domain\Work\TeamworkCalculator;
use App\Models\User;
use App\Models\Work\Team\TeamWorker;
use App\Repositories\TeamworkRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Validators\Work\TeamworkValidator;

class TeamworksController extends Controller
{

    public function readyToTeamworkAction()
    {
        $data = Input::all();

        TeamWorker::
            where('worker_user_id', $this->user_id)
            ->update(['status' => 'ready']);

//        когда первый отдает сигнал, что готов запускается таймер ан 10 минут
//        Если в этой группе все готовы - работа начинается? таймер по готовности удаляется
        // заводится таймер на работу

        return Redirect::route('work_show_teamwork_page', ['id' => $data['privateteam_id']]);
    }

    public function showTeamWork($id)
    {
        /** @var PrivateTeam $team */
        $team = TeamworkRepository::getTeamworkWithCreatorAndPartnersById($id);

        if (TeamworkValidator::isWorkersReadyToWork($team))
        {
            // all workers are ready, start_working
            TeamworkCalculator::privateTeamWork($team);
            // end of work

            // change worker status after work
            TeamworkRepository::changeWorkerStatusAfterWork($team, 'inactive');

            Session::flash('teamWork is started');
        }
        else {
            Session::flash('Работа не начнется пока все воркеры не будут готовы');
        }

        $workers = TeamworkRepository::getWorkersByTeam($team);

        return $this->view('work/team/privateteam_work', [
            'privateteam' => $team,
            'workers' => $workers,
        ]);
    }
}
