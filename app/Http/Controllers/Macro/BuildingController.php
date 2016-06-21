<?php

namespace App\Http\Controllers\Macro;

use App\Http\Controllers\MacroController;
use App\Http\Requests;
use App\Http\Requests\Process\BuildConcreteRequest;
use App\Http\Requests\Process\BuildRequest;
use App\Models\Macro\Building;
use App\Models\Macro\BuildingFarm;
use App\Models\Macro\BuildingSmith;
use App\Repositories\Macro\BuildingsRepository;
use App\Repositories\Macro\ResourcesRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class BuildingController extends MacroController
{
    public function index()
    {
        $user = auth()->user();

        $buildings = BuildingsRepository::getBuildingsWithConcreteByUser($user);
        
        $freeBuildings = BuildingsRepository::getFreeBuildingsByUser($user);

        return $this->view('macro/buildings', [
            'buildings' => $buildings,
            'freeBuildings' => $freeBuildings,
        ]);
    }

    public function equip(BuildConcreteRequest $request)
    {
        $user_id = $this->user_id;
        $building_id = $request->get('building_id');
        $kind = $request->get('kind');
        $title = $request->get('title');

        $building = Building::find($building_id);

        DB::beginTransaction();
        try {

            if ($kind === 'smith') {
                $smith = BuildingSmith::create([
                    'user_id' => $user_id,
                    'building_id' => $building_id,
                    'title' => $title,
                    'level' => 1,
                ]);

                $smith->save();
                $building->concrete_building_id = $smith->id;
                $building->kind = BuildingSmith::class;
            }
            elseif ($kind === 'farm') {
                $farm = new BuildingFarm();
                $farm->user_id = $user_id;
                $farm->building_id = $building_id;
                $farm->title = $title;
                $farm->level = 1;

                $farm->save();
                $building->concrete_building_id = $farm->id;
                $building->kind = BuildingFarm::class;
            }
            else {
                throw new Exception('unknown build kind');
            }
            $building->save();

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

        return redirect('/macro/buildings');
    }

    public function build (BuildRequest $request)
    {
        $user = auth()->user();

        DB::transaction(function () use ($user) {
            BuildingsRepository::createBuilding($user);
            ResourcesRepository::decrementResourceByUser($user->id, 'tree', 60);
            ResourcesRepository::decrementResourceByUser($user->id, 'food', 70);
        });
        
        return Redirect::route('macro_buildings_page');
    }

    public function show($building_id)
    {
        $building = Building::find($building_id);

        return $this->view('macro/show', [
            'building' => $building,
        ]);
    }

    public function smithWork()
    {
        return Redirect::route('macro_buildings_smith', ['id' => 1]);
    }
}
