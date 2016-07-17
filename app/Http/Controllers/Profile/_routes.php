<?php


Route::get('/profile', 'Profile\ProfileController@index')->name('profile_page');
Route::get('/profile/channels', 'Profile\ProfileController@channels')->name('profile_channels_page');

Route::post('/profile/become_driver', 'Profile\ProfileController@becomeDriver')->name('profile_become_driver_action');



Route::get('/profile/buildings', 'Profile\ProfileController@buildings')->name('profile_buildings_page');
