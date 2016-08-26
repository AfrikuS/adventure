<?php

namespace App\Modules\Drive\Controllers\Admin\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Drive\Catalogs\DetailKind;
use App\Models\Drive\Catalogs\DetailTitle;
use App\Modules\Drive\Persistence\Repositories\CatalogsRepo;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class CatalogsController extends Controller
{
    public function index()
    {
        /** @var CatalogsRepo $driveCatalogs */
        $driveCatalogs = app('DriveCatalogsRepo');
        
        $detailKinds = $driveCatalogs->getDetailsKinds();
        
        $detailTitles = $driveCatalogs->getDetailsTitles();

        return $this->view('admin.drive.catalogs', [
            'detailKinds' =>  $detailKinds,
            'detailTitles' => $detailTitles,
//            'skills' => $skills,
        ]);
    }

    
    
    public function createDetailKind()
    {
        $data = Input::all();
        $kind = $data['detail_kind'];

        /** @var CatalogsRepo $driveCatalogs */
        $driveCatalogs = app('DriveCatalogsRepo');


        $driveCatalogs->createDetailKind($kind);

        
        return \Redirect::route('admin_module_drive_page');
    }

    public function createDetailTitle()
    {
        $data = Input::all();
        $kind_id = $data['kind_id'];
        $title = $data['title'];

        /** @var CatalogsRepo $driveCatalogs */
        $driveCatalogs = app('DriveCatalogsRepo');


        $driveCatalogs->createDetailTitle($title, $kind_id);
        

        return \Redirect::route('admin_module_drive_page');
    }

}
