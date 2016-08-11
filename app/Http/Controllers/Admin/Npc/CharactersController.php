<?php

namespace App\Http\Controllers\Admin\Npc;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Controller;
use App\Models\Npc\Character;
use Illuminate\Support\Facades\Input;

class CharactersController extends Controller
{
    public function index()
    {
        $chars = Character::get();

        return $this->view('admin.npc.characters', [
            'characters' => $chars,
        ]);
    }

    public function add()
    {
        $data = Input::all();
        $name = $data['name'];
        
        Character::create([
            'name' => $name,
        ]);
        
        return \Redirect::route('admin_module_npc_page');
    }
}
