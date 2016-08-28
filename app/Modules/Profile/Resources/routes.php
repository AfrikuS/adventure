<?php


Route::get('/profile', 'Profile\Controllers\ProfileController@index')->name('profile_page');

Route::post('/profile/become_driver', 'Profile\Controllers\ProfileController@becomeDriver')->name('profile_become_driver_action');



Route::get('/profile/buildings', 'Profile\Controllers\ProfileController@buildings')->name('profile_buildings_page');





Route::get('/profile/stores', 'Profile\ResourceStoreController@index')->name('profile_resource_stores_page');
Route::post('/profile/oil_store/upgrade', 'Profile\ResourceStoreController@upgradeOilStore')->name('hero_oil_store_upgrade_action');
Route::post('/profile/petrol_store/upgrade', 'Profile\ResourceStoreController@upgradePetrolStore')->name('hero_petrol_store_upgrade_action');
Route::post('/profile/water_store/upgrade', 'Profile\ResourceStoreController@upgradeWaterStore')->name('hero_water_store_upgrade_action');

Route::post('/profile/pump_oil/upgrade', 'Profile\EquipmentController@upgradePumpOil')->name('hero_pumpoil_upgrade_action');
Route::post('/profile/pump_oil/buy', 'Profile\EquipmentController@buyPumpOil')->name('hero_pumpoil_buy_action');

Route::post('/profile/oildistillator/upgrade', 'Profile\EquipmentController@upgradeOilDistillator')->name('hero_oildistillator_upgrade_action');
Route::post('/profile/oildistillator/buy', 'Profile\EquipmentController@buyOilDistillator')->name('hero_oildistillator_buy_action');
