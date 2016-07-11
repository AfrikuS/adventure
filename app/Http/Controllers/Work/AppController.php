<?php

namespace App\Http\Controllers\Work;

use App\Models\Work\Worker;
use App\Repositories\Work\WorkerRepositoryObj;
use Illuminate\Support\Facades\Session;

class AppController extends \App\Http\Controllers\Controller
{
    /** @var WorkerRepositoryObj */
    protected $workerRep;
    /** @var  Worker */
    protected $worker;

    public function __construct(WorkerRepositoryObj $workerRep)
    {
        $this->workerRep = $workerRep;

        try 
        {
            $this->worker = $this->workerRep->findSimpleById(\Auth::id());
        }
        
        catch (\Exception $e) {
            
            Session::flash('message', 'AppCtrl -> You are not worker');
            
            return \Redirect::back();
        }

        parent::__construct();
    }
    
    protected function view($view = null, $data = [])
    {
        $data['worker'] = (object) $this->worker->toArray();

        return parent::view($view, $data);
    }

}
