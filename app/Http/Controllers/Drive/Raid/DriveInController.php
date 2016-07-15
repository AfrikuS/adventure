<?php

namespace App\Http\Controllers\Drive\Raid;

use App\Commands\Drive\Raid\Robbery\Collision\CollisionFenceCommand;
use App\Commands\Drive\Raid\Robbery\Collision\CollisionGatesCommand;
use App\Commands\Drive\Raid\Robbery\Collision\FailedCollisionHandler;
use App\Lib\Drive\Raid\Robbery\CollisionProcessor;
use App\Repositories\Drive\DriverRepository;
use App\Repositories\Drive\RaidRepository;
use Illuminate\Support\Facades\Redirect;

class DriveInController extends RobberyController
{
    /** @var  CollisionProcessor */
    private $collisionProcessor;

    public function __construct(DriverRepository $driverRepo, RaidRepository $raidRepo)
    {
        parent::__construct($driverRepo, $raidRepo);
        
        $buildings = $this->victim->getRelation('buildings');

        $this->collisionProcessor = new CollisionProcessor($this->vehicle, $buildings);
    }

    public function driveInGates()
    {
        if ($this->robbery->state != 'gates') {
            return \Redirect::route('drive_robbery_page');
        }

        $collisionResult = $this->collisionProcessor->processCollision('gates');

        
        if ($collisionResult->status == 'success') {

            $cmd = new CollisionGatesCommand($collisionResult);
            
            $cmd->handleCollision($this->raid, $this->robbery, $this->vehicle);


            return $this->view('drive.robbery.crush_result_success', [
                'result' => $collisionResult,
            ]);
        }
        
        else {
            
            $handler = new FailedCollisionHandler($collisionResult);

            $handler->handle($this->vehicle);


            return $this->view('drive.robbery.crush_result_fail', [
                'result' => $collisionResult,
            ]);

        }
    }

    public function driveInFence()
    {
        if ($this->robbery->state != 'fence') {
            return \Redirect::route('drive_robbery_page');
        }

        $collisionResult = $this->collisionProcessor->processCollision('fence');


        if ($collisionResult->status == 'success') {

            $cmd = new CollisionFenceCommand($collisionResult);

            $cmd->handleCollision($this->raid, $this->robbery, $this->vehicle);


            return $this->view('drive.robbery.crush_result_success', [
                'result' => $collisionResult,
            ]);
        }

        else {

            $handler = new FailedCollisionHandler($collisionResult);

            $handler->handle($this->vehicle);


            return $this->view('drive.robbery.crush_result_fail', [
                'result' => $collisionResult,
            ]);

        }
    }

    public function driveInHouse()
    {
        if ($this->robbery->state != 'courtyard') {
            return \Redirect::route('drive_robbery_page');
        }

        $collisionResult = $this->collisionProcessor->processCollision('house');


        if ($collisionResult->status == 'success') {

            $this->robbery->driveInHouse();

            return $this->view('drive.robbery.house', [
            ]);
        }

        else {

            $handler = new FailedCollisionHandler($collisionResult);

            $handler->handle($this->vehicle);


            return $this->view('drive.robbery.crush_result_fail', [
                'result' => $collisionResult,
            ]);

        }
    }

    public function driveInAmbar()
    {
        if ($this->robbery->state != 'courtyard') {
            return \Redirect::route('drive_robbery_page');
        }

        $collisionResult = $this->collisionProcessor->processCollision('ambar');


        if ($collisionResult->status == 'success') {

            $this->robbery->driveInAmbar();

            return $this->view('drive.robbery.ambar', [
            ]);
        }

        else {

            $handler = new FailedCollisionHandler($collisionResult);

            $handler->handle($this->vehicle);


            return $this->view('drive.robbery.crush_result_fail', [
                'result' => $collisionResult,
            ]);

        }
    }

    public function driveInWarehouse()
    {
        if ($this->robbery->state != 'courtyard') {
            return \Redirect::route('drive_robbery_page');
        }

        $collisionResult = $this->collisionProcessor->processCollision('warehouse');


        if ($collisionResult->status == 'success') {

            $this->robbery->driveInWarehouse();

            return $this->view('drive.robbery.warehouse', [
            ]);
        }

        else {

            $handler = new FailedCollisionHandler($collisionResult);

            $handler->handle($this->vehicle);


            return $this->view('drive.robbery.crush_result_fail', [
                'result' => $collisionResult,
            ]);
        }
    }
}
