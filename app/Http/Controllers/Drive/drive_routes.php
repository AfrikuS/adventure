<?php


Route::get('/drive/garage/repair', 'Drive\GarageController@repairPage')->name('drive_garage_repair_page');

Route::get('/drive/shop', 'Drive\ShopController@index')->name('drive_garage_shop_page');
Route::post('/drive/shop/reindex', 'Drive\ShopController@reindexPrices')->name('drive_shop_reindex_prices_action');
Route::post('/drive/shop/buy_detail', 'Drive\ShopController@buyDetail')->name('drive_shop_buy_detail_action');



Route::get('/drive/pit_stop', 'Drive\PitStopController@index')->name('drive_service_station_page');



Route::get('/drive/vehicle', 'Drive\VehicleController@index')->name('drive_garage_vehicle_page');
Route::post('/drive/vehicle/mountDetail', 'Drive\VehicleController@mountDetail')->name('drive_vehicle_mount_detail_action');
Route::post('/drive/vehicle/unmountDetail', 'Drive\VehicleController@unmountDetail')->name('drive_vehicle_unmount_detail_action');
