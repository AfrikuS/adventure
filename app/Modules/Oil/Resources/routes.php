<?php


Route::get('/profile/base/oil_pump', 'Oil\Http\Controllers\Profile\Base\OilPumpController@index')->name('base_oilpump_page');

Route::post('/profile/base/oil_pump/upgrade', 'Oil\Http\Controllers\Profile\Base\OilPumpController@upgrade')->name('base_oilpump_upgrade_action');
Route::post('/profile/base/oil_pump/process', 'Oil\Http\Controllers\Profile\Base\OilPumpController@process')->name('base_oilpump_process_action');

