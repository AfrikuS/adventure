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

        $this->collisionProcessor = new CollisionProcessor($this->vehicle);
    }

    public function driveInGates()
    {
        if ($this->robbery->state != 'near_gates') {
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
        if ($this->robbery->state != 'near_fence') {
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
}
