<?php

namespace App\Http\Controllers\Geo;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Geo\Island;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class IslandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $islands = Island::paginate(15);

        return $this->view('geo.islands.index', compact('islands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return $this->view('geo.islands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store(Request $request)
    {
        $props = $request->all();
        $island = new Island($props);
        $user_id = auth()->user()->id;
        $island->user_id = $user_id;

        Session::flash('flash_message', 'Island added!');

        return redirect('islands');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id)
    {
        $island = Island::findOrFail($id);

        return $this->view('geo.islands.show', compact('island'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id)
    {
        $island = Island::findOrFail($id);

        return $this->view('geo.islands.edit', compact('island'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function update($id, Request $request)
    {
        
        $island = Island::findOrFail($id);
        $island->update($request->all());

        Session::flash('flash_message', 'Island updated!');

        return redirect('islands');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id)
    {
        Island::destroy($id);

        Session::flash('flash_message', 'Island deleted!');

        return redirect('islands');
    }
}
