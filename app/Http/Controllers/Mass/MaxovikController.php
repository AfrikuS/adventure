<?php

namespace App\Http\Controllers\Mass;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

class MaxovikController extends Controller
{
    public function index()
    {
        return $this->view('mass/maxovik', []);
    }
}
