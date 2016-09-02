<?php

namespace App\Modules\Npc\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Modules\Core\Http\Controller;
use App\Models\Npc\Character;
use App\Modules\Npc\Persistence\Repositories\CharactersRepo;
use Illuminate\Support\Facades\Input;

class CharactersController extends Controller
{
    /** @var CharactersRepo */
    private $characters;

    public function __construct(CharactersRepo $characters)
    {
        parent::__construct();

        $this->characters = $characters; // app('CharactersRepo');
    }

    public function index()
    {
        $chars = $this->characters->get();

        return $this->view('admin.npc.characters', [
            'characters' => $chars,
        ]);
    }

    public function add()
    {
        $data = Input::all();
        $name = $data['name'];

        $this->characters->create($name);
        
        return \Redirect::route('admin_module_npc_page');
    }
}
