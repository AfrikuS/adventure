<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class BattleController extends Controller
{
    public function index()
    {
        return $this->view('mass/battle', [
        ]);
    }

    public function form()
    {
        $props = Input::all();
    }
}
