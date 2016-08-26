<?php

namespace App\Modules\Drive\Controllers\Raid\Robbery;

use App\Commands\Drive\Raid\Robbery\Collision\FailedCollisionHandler;
use App\Lib\Drive\Raid\Robbery\CollisionProcessor;
use App\Modules\Drive\Commands\Raid\Robbery\Collision\CollisionAmbarDoorCommand;
use App\Modules\Drive\Commands\Raid\Robbery\Collision\CollisionFenceCommand;
use App\Modules\Drive\Commands\Raid\Robbery\Collision\CollisionGatesCommand;
use App\Modules\Drive\Commands\Raid\Robbery\Collision\CollisionHouseDoorCommand;
use App\Modules\Drive\Commands\Raid\Robbery\Collision\CollisionWarehouseDoorCommand;
use App\Modules\Drive\Controllers\Raid\RobberyController;
use App\Modules\Drive\Exceptions\Controllers\CollisionSuccess_Exception;
use App\Modules\Drive\Exceptions\Controllers\CollisionUnsuccess_Exception;
use App\Repositories\Drive\DriverRepository;
use App\Repositories\Drive\RaidRepository;
use Finite\Exception\StateException;
use Illuminate\Support\Facades\Redirect;

class CollisionController extends RobberyController
{
//    /** @var  CollisionProcessor */
//    private $collisionProcessor;

    public function __construct()
    {
        parent::__construct();
        
//        $buildings = $this->victim->getRelation('buildings');

//        $this->collisionProcessor = new CollisionProcessor($this->vehicle, $buildings);
    }

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
