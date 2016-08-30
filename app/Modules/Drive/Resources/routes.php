<?php

//Route::group(['middleware' => 'app_auth'], function () {


Route::get('/drive', 'Drive\Controllers\Garage\VehicleController@index')->name('drive_garage_vehicle_page');




Route::get('/drive/shop', 'Drive\Controllers\Garage\ShopController@index')->name('drive_garage_shop_page');
Route::post('/drive/shop/reindex', 'Drive\Controllers\Garage\ShopController@reindexPrices')->name('drive_shop_reindex_prices_action');
Route::post('/drive/shop/buy_detail', 'Drive\Controllers\Garage\ShopController@buyDetail')->name('drive_shop_buy_detail_action');




Route::post('/drive/vehicle/mountDetail', 'Drive\Controllers\Garage\VehicleController@mountDetail')->name('drive_vehicle_mount_detail_action');
Route::post('/drive/vehicle/unmountDetail', 'Drive\Controllers\Garage\VehicleController@unmountDetail')->name('drive_vehicle_unmount_detail_action');
Route::get('/drive/vehicle/equip_to_raid', 'Drive\Controllers\Garage\VehicleController@equipToRaid')->name('drive_vehicle_equip_to_raid_page');


Route::get('/drive/pit_stop', 'Drive\PitStopController@index')->name('drive_service_station_page');



Route::get('/drive/workroom', 'Drive\Controllers\Garage\WorkroomController@index')->name('drive_workroom_page');
Route::post('/drive/workroom/repair', 'Drive\Controllers\Garage\WorkroomController@repair')->name('drive_workroom_repair_action');
Route::post('/drive/workroom/recovery', 'Drive\Controllers\Garage\WorkroomController@recovery')->name('drive_workroom_recovery_action');
Route::post('/drive/workroom/refuel', 'Drive\Controllers\Garage\WorkroomController@refuel')->name('drive_workroom_refuel_action');


Route::group(['middleware' => 'drive_driver'], function () {



    Route::post('/drive/raid/finish', 'Drive\Controllers\Raid\RaidController@finish')->name('drive_raid_finish_action');
    Route::get('/drive/raid/vehicle_broken', 'Drive\Controllers\Raid\RaidController@vehicleBroken')->name('drive_raid_vehicle_broken_page');

// все дейсвия всё одно в мидлвар не загонишь - ищи другие пути
    Route::group(['middleware' => 'drive_vehicle_broken'], function () {


        Route::post('/drive/start_raid', 'Drive\Controllers\Raid\RaidController@startRaid')->name('drive_raid_start_action');
        Route::post('/drive/raid/search_victim', 'Drive\Controllers\Raid\RaidController@searchVictim')->name('drive_raid_search_victim_action');
        Route::post('/drive/raid/start_robbery', 'Drive\Controllers\Raid\RaidController@startRobbery')->name('drive_raid_robbery_start_action');

        Route::get('/drive/raid', 'Drive\Controllers\Raid\RaidController@show')->name('drive_raid_page');





        Route::get('/drive/robbery', 'Drive\Controllers\Raid\RobberyController@show')->name('drive_robbery_page');

//        Route::post('/drive/robbery/driveto_gates', 'Drive\Controllers\Raid\RobberyController@driveToGates')->name('drive_robbery_driveto_gates_action');
        Route::post('/drive/robbery/view_gates', 'Drive\Controllers\Raid\RobberyController@detailViewGates')->name('drive_robbery_view_gates_action');



        Route::post('/drive/robbery/drivein_gates', 'Drive\Controllers\Raid\Robbery\CollisionController@driveInGates')->name('drive_robbery_drivein_gates_action');
        Route::post('/drive/robbery/drivein_fence', 'Drive\Controllers\Raid\Robbery\CollisionController@driveInFence')->name('drive_robbery_drivein_fence_action');

        Route::post('/drive/robbery/drivein_ambar', 'Drive\Controllers\Raid\Robbery\CollisionController@driveInAmbar')->name('drive_robbery_drivein_ambar_action');
        Route::post('/drive/robbery/drivein_house', 'Drive\Controllers\Raid\Robbery\CollisionController@driveInHouse')->name('drive_robbery_drivein_house_action');
        Route::post('/drive/robbery/drivein_warehouse', 'Drive\Controllers\Raid\Robbery\CollisionController@driveInWarehouse')->name('drive_robbery_drivein_warehouse_action');

        Route::post('/drive/robbery/finish', 'Drive\Controllers\Raid\RobberyController@finish')->name('drive_robbery_finish_action');
        Route::post('/drive/robbery/abort', 'Drive\Controllers\Raid\RobberyController@abort')->name('drive_robbery_abort_action');

    });


});



//});
// admin
Route::get('/admin/drive', 'Drive\Controllers\Admin\Catalogs\CatalogsController@index')->name('admin_module_drive_page');
Route::post('/generate/drive/create_detail_kind', 'Drive\Controllers\Admin\Catalogs\CatalogsController@createDetailKind')->name('create_detail_kind_action');
Route::post('/generate/drive/create_detail_title', 'Drive\Controllers\Admin\Catalogs\CatalogsController@createDetailTitle')->name('create_detail_title_action');
