<?php

namespace App\Http\Controllers\Drive;

use App\Http\Controllers\Controller;
use App\Models\Drive\Driver;
use App\Repositories\Drive\DriverRepository;

class AppController extends Controller
{
    /** @var  DriverRepository */
    protected $driverRepo;
    /** @var  Driver */
    protected $driver;

    public function __construct(DriverRepository $driverRepo)
    {
        parent::__construct();


        $this->driverRepo = $driverRepo;

        $this->driver = $this->driverRepo->findById($this->user_id);

        if (null === $this->driver) {
            $this->driver = $this->driverRepo->createDriver($this->user_id);
        }
    }
    
    protected function view($view = null, $data = [])
    {
        
        $data['driver'] = (object) $this->driver->toArray();
        
        return parent::view($view, $data);
    }

}
