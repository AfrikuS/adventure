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
    /** @var CatalogsRepo */
    private $driveCatalogsRepo;

    public function __construct(CatalogsRepo $driveCatalogsRepo)
    {
        parent::__construct();

        $this->driveCatalogsRepo = $driveCatalogsRepo;
    }

    public function index()
    {
        $detailKinds = $this->driveCatalogsRepo->getDetailsKinds();
        
        $detailTitles = $this->driveCatalogsRepo->getDetailsTitles();

        return $this->view('admin.drive.catalogs', [
            'detailKinds' =>  $detailKinds,
            'detailTitles' => $detailTitles,
        ]);
    }
    
    public function createDetailKind()
    {
        $data = Input::all();
        $kind = $data['detail_kind'];


        $this->driveCatalogsRepo->createDetailKind($kind);

        
        return \Redirect::route('admin_module_drive_page');
    }

    public function createDetailTitle()
    {
        $data = Input::all();
        $kind_id = $data['kind_id'];
        $title = $data['title'];


        $this->driveCatalogsRepo->createDetailTitle($title, $kind_id);
        

        return \Redirect::route('admin_module_drive_page');
    }
}
