<?php

namespace App\Http\Controllers\Admin\Drive;

use App\Http\Controllers\Controller;
use App\Models\Drive\Catalogs\DetailKind;
use App\Models\Drive\Catalogs\DetailTitle;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class CatalogsController extends Controller
{
    public function index()
    {
        $detailKinds = DetailKind::get();
        $detailTitles = DetailTitle::get();

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

        DetailKind::create([
            'title' => $kind,
        ]);

        return \Redirect::route('admin_module_drive_page');
    }

    public function createDetailTitle()
    {
        $data = Input::all();
        $kind_id = $data['kind_id'];
        $title = $data['title'];

        DetailTitle::create([
            'title' => $title,
            'kind_id' => $kind_id,
        ]);

        return \Redirect::route('admin_module_drive_page');
    }

}
