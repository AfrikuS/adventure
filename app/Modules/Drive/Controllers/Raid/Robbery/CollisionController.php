<?php

namespace App\Modules\Drive\Controllers\Raid\Robbery;

use App\Modules\Drive\Actions\Raid\Robbery\Collision\CollisionAmbarDoorCommand;
use App\Modules\Drive\Actions\Raid\Robbery\Collision\CollisionFenceCommand;
use App\Modules\Drive\Actions\Raid\Robbery\Collision\CollisionGatesCommand;
use App\Modules\Drive\Actions\Raid\Robbery\Collision\CollisionHouseDoorCommand;
use App\Modules\Drive\Actions\Raid\Robbery\Collision\CollisionWarehouseDoorCommand;
use App\Modules\Drive\Controllers\Raid\RobberyController;
use App\Modules\Drive\Exceptions\Controllers\CollisionSuccess_Exception;
use App\Modules\Drive\Exceptions\Controllers\CollisionUnsuccess_Exception;
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
        catch (CollisionSuccess_Exception $e) {

            return $this->view('drive.raid.robbery.crush_result_success', [
                'result' => $e->collisionResult,
            ]);
        }
        catch (CollisionUnsuccess_Exception $e) {

            return $this->view('drive.raid.robbery.crush_result_fail', [
                'result' => $e->collisionResult,
            ]);
        }
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
        catch (CollisionSuccess_Exception $e) {

            return $this->view('drive.raid.robbery.crush_result_success', [
                'result' => $e->collisionResult,
            ]);
        }
        catch (CollisionUnsuccess_Exception $e) {

            return $this->view('drive.raid.robbery.crush_result_fail', [
                'result' => $e->collisionResult,
            ]);
        }
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
        catch (CollisionSuccess_Exception $e) {


            return $this->view('drive.raid.robbery.house', [
            ]);
        }
        catch (CollisionUnsuccess_Exception $e) {

            return $this->view('drive.raid.robbery.crush_result_fail', [
                'result' => $e->collisionResult,
            ]);
        }
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
        catch (CollisionSuccess_Exception $e) {


            return $this->view('drive.raid.robbery.ambar', [
            ]);
        }
        catch (CollisionUnsuccess_Exception $e) {

            return $this->view('drive.raid.robbery.crush_result_fail', [
                'result' => $e->collisionResult,
            ]);
        }
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
        catch (CollisionSuccess_Exception $e) {

            return $this->view('drive.raid.robbery.warehouse', [
            ]);
//            return $this->view('drive.raid.robbery.crush_result_success', [
//                'result' => $e->collisionResult,
//            ]);

        }
        catch (CollisionUnsuccess_Exception $e) {

            return $this->view('drive.raid.robbery.crush_result_fail', [
                'result' => $e->collisionResult,
            ]);
        }
    }
}
