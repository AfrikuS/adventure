<?php

// employment-module
Route::get('/profile/lore', 'Employment\Http\Controllers\Profile\LoreController@index')->name('employment_profile_page');



Route::get('/employment/school', 'Employment\Http\Controllers\School\SchoolController@index')->name('employment_school_page');
Route::post('/employment/school/get_license', 'Employment\Http\Controllers\School\SchoolController@getLicense')->name('school_get_license_action');
//Route::post('/employment/school/get_vehicle_license', 'Employment\School\SchoolController@getVehicleRecoveryLicense')->name('school_get_vehicle_recovery_license_action');

Route::get('/employment/school/classroom/{domain_id}', 'Employment\Http\Controllers\School\SchoolController@classroom')->name('school_classroom_page');
//
Route::post('/employment/school/learn', 'Employment\Http\Controllers\School\SchoolController@processSchoolTask')->name('employment_school_learn_action');


//Route::get('/employment/test', 'Employment\PolygonController@test')->name('employment_test_page');
