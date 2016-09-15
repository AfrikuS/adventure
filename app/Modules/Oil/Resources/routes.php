<?php

// base-equipments

Route::get('/profile/base/oil_pump', 'Oil\Http\Controllers\Profile\Base\OilPumpController@index')->name('base_oilpump_page');

Route::post('/profile/base/oil_pump/upgrade', 'Oil\Http\Controllers\Profile\Base\OilPumpController@upgrade')->name('base_oilpump_upgrade_action');
Route::post('/profile/base/oil_pump/process', 'Oil\Http\Controllers\Profile\Base\OilPumpController@process')->name('base_oilpump_process_action');


Route::get('/profile/base/oil_distiller', 'Oil\Http\Controllers\Profile\Base\OilDistillerController@index')->name('base_oil_distiller_page');

Route::post('/profile/base/oil_distiller/upgrade', 'Oil\Http\Controllers\Profile\Base\OilDistillerController@upgrade')->name('base_oil_distiller_upgrade_action');
Route::post('/profile/base/oil_distiller/process', 'Oil\Http\Controllers\Profile\Base\OilDistillerController@process')->name('base_oil_distiller_process_action');


