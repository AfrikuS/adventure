<?php

Route::group(['middleware' => 'drive_driver'], function () {

    
    Route::get('/drive/shop', 'Drive\Garage\ShopController@index')->name('drive_garage_shop_page');
    Route::post('/drive/shop/reindex', 'Drive\Garage\ShopController@reindexPrices')->name('drive_shop_reindex_prices_action');
    Route::post('/drive/shop/buy_detail', 'Drive\Garage\ShopController@buyDetail')->name('drive_shop_buy_detail_action');
    
    
    
    
    Route::get('/drive', 'Drive\Garage\VehicleController@index')->name('drive_garage_vehicle_page');
    Route::post('/drive/vehicle/mountDetail', 'Drive\Garage\VehicleController@mountDetail')->name('drive_vehicle_mount_detail_action');
    Route::post('/drive/vehicle/unmountDetail', 'Drive\Garage\VehicleController@unmountDetail')->name('drive_vehicle_unmount_detail_action');
    Route::get('/drive/vehicle/equip_to_raid', 'Drive\Garage\VehicleController@equipToRaid')->name('drive_vehicle_equip_to_raid_page');
    
    
    Route::get('/drive/pit_stop', 'Drive\PitStopController@index')->name('drive_service_station_page');



    Route::get('/drive/workroom', 'Drive\Garage\WorkroomController@index')->name('drive_workroom_page');
    Route::post('/drive/workroom/repair', 'Drive\Garage\WorkroomController@repair')->name('drive_workroom_repair_action');
    Route::post('/drive/workroom/recovery', 'Drive\Garage\WorkroomController@recovery')->name('drive_workroom_recovery_action');
    Route::post('/drive/workroom/refuel', 'Drive\Garage\WorkroomController@refuel')->name('drive_workroom_refuel_action');

    
    
    
    Route::post('/drive/raid/finish', 'Drive\Raid\RaidController@finish')->name('drive_raid_finish_action');
    Route::get('/drive/raid/vehicle_broken', 'Drive\Raid\RaidController@vehicleBroken')->name('drive_raid_vehicle_broken_page');

// все дейсвия всё одно в мидлвар не загонишь - ищи другие пути
    Route::group(['middleware' => 'drive_vehicle_broken'], function () {


        Route::post('/drive/start_raid', 'Drive\DriveController@startRaid')->name('drive_raid_start_action');
        Route::post('/drive/raid/search_victim', 'Drive\Raid\RaidController@searchVictim')->name('drive_raid_search_victim_action');
        Route::post('/drive/raid/start_robbery', 'Drive\Raid\RaidController@startRobbery')->name('drive_raid_robbery_start_action');
        
        Route::get('/drive/raid', 'Drive\Raid\RaidController@show')->name('drive_raid_page');
        
        
        
        
        
        Route::get('/drive/robbery', 'Drive\Raid\RobberyController@show')->name('drive_robbery_page');
        
        Route::post('/drive/robbery/driveto_gates', 'Drive\Raid\RobberyController@driveToGates')->name('drive_robbery_driveto_gates_action');
        Route::post('/drive/robbery/view_gates', 'Drive\Raid\RobberyController@detailViewGates')->name('drive_robbery_view_gates_action');
    
    
    
        Route::post('/drive/robbery/drivein_gates', 'Drive\Raid\DriveInController@driveInGates')->name('drive_robbery_drivein_gates_action');
        Route::post('/drive/robbery/drivein_fence', 'Drive\Raid\DriveInController@driveInFence')->name('drive_robbery_drivein_fence_action');
        
        Route::post('/drive/robbery/drivein_ambar', 'Drive\Raid\DriveInController@driveInAmbar')->name('drive_robbery_drivein_ambar_action');
        Route::post('/drive/robbery/drivein_house', 'Drive\Raid\DriveInController@driveInHouse')->name('drive_robbery_drivein_house_action');
        Route::post('/drive/robbery/drivein_warehouse', 'Drive\Raid\DriveInController@driveInWarehouse')->name('drive_robbery_drivein_warehouse_action');
        
        Route::post('/drive/robbery/finish', 'Drive\Raid\RobberyController@finish')->name('drive_robbery_finish_action');
        Route::post('/drive/robbery/abort', 'Drive\Raid\RobberyController@abort')->name('drive_robbery_abort_action');

    });


});


