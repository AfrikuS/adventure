<?php

namespace App\Http\Controllers\Railway;

use App\Http\Controllers\Controller;
use App\Models\Railway\StationLicense;
use App\Repositories\Railway\RailwayRepository;
use Carbon\Carbon;

class RailwayController extends Controller
{
    /** @var  RailwayRepository */
    protected $railwayRepo;

    public function __construct()
    {
        parent::__construct();
        $this->railwayRepo = new RailwayRepository();
    }

    public function director()
    {

        $license = $this->railwayRepo->findLicenseByHeroId($this->user_id);

        return $this->view('railway.director', [
            'license' => $license,
        ]);
    }

    public function buyLicense()
    {
        $license = $this->railwayRepo->findLicenseByHeroId($this->user_id);
        
        $endDate = Carbon::create()->addHours(3);

        if (null == $license) {
            StationLicense::create([
                'id' => $this->user_id,
                'level' => 1,
                'status' => 'active',
                'end_time' => $endDate->toDateTimeString(),
            ]);
        }
        else {
            $currDate = Carbon::createFromFormat(Carbon::DEFAULT_TO_STRING_FORMAT, $license->end_time);
            $currDate->addHours(3);

            $license->update([
                'end_time' => $currDate->toDateTimeString(),
            ]);
        }

        return \Redirect::route('railway_trades_page');
    }
}
