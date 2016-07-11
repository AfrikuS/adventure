<?php


Route::get('/profile', 'Profile\ProfileController@index')->name('profile_page');
Route::get('/profile/channels', 'Profile\ProfileController@channels')->name('profile_channels_page');
