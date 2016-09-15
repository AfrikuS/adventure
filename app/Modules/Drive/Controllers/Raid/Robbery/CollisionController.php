<?php

namespace App\Modules\Drive\Controllers\Raid\Robbery;

use App\Modules\Drive\Actions\Raid\Robbery\Collision\CollisionAmbarDoorCommand;
use App\Modules\Drive\Actions\Raid\Robbery\Collision\CollisionFenceCommand;
use App\Modules\Drive\Actions\Raid\Robbery\Collision\CollisionGatesCommand;
use App\Modules\Drive\Actions\Raid\Robbery\Collision\CollisionHouseDoorCommand;
use App\Modules\Drive\Actions\Raid\Robbery\Collision\CollisionWarehouseDoorCommand;
use App\Modules\Drive\Controllers\Raid\RobberyController;
use Finite\Exception\StateException;

class CollisionController extends RobberyController
{
    public function driveInGates()
    {
        $command = new CollisionGatesCommand();

        try {

            $command->driveInGates($this->user_id);
        }
        catch (StateException $e) {

            return \Redirect::route('drive_robbery_page');
        }
        return \Redirect::route('drive_robbery_collision_result_action');
    }

    public function driveInFence()
    {
        $command = new CollisionFenceCommand();

        try {

            $command->driveInFence($this->user_id);
        }
        catch (StateException $e) {

            return \Redirect::route('drive_robbery_page');
        }
        return \Redirect::route('drive_robbery_collision_result_action');
    }
    
    public function driveInHouse()
    {
        $command = new CollisionHouseDoorCommand();

        try {

            $command->houseDoorCollision($this->user_id);
        }
        catch (StateException $e) {

            return \Redirect::route('drive_robbery_page');
        }
        return \Redirect::route('drive_robbery_collision_result_action');
    }

    public function driveInAmbar()
    {
        $command = new CollisionAmbarDoorCommand();

        try {

            $command->ambarDoorCollision($this->user_id);
        }
        catch (StateException $e) {

            return \Redirect::route('drive_robbery_page');
        }

        return \Redirect::route('drive_robbery_collision_result_action');
    }

    public function driveInWarehouse()
    {
        $command = new CollisionWarehouseDoorCommand();

        try {

            $command->warehouseDoorCollision($this->user_id);
        }
        catch (StateException $e) {

            return \Redirect::route('drive_robbery_page');
        }

        return \Redirect::route('drive_robbery_collision_result_action');
    }

    public function collisionResult()
    {
        if (rand(1, 3) > 1) {

            return $this->view('drive.raid.robbery.collisions.crush_result_success', [
            ]);
        }
        else {

            return $this->view('drive.raid.robbery.collisions.crush_result_fail', [
            ]);
        }
    }
}
