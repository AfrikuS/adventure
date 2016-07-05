<?php


Route::get('/sign_in', 'NotAuth\GuestController@signIn')->name('sign_in_page');
Route::get('/sign_up', 'NotAuth\GuestController@signUp')->name('sign_up_page');
Route::get('/logout', 'Auth\UserController@logout')->name('logout_action');

Route::post('/login', 'NotAuth\GuestController@login')->name('sign_in_action');
Route::post('/register', 'Auth\UserController@register')->name('sign_up_action');

Route::get('/', 'NotAuth\IndexController@index')->name('index_page');
Route::get('/test', 'NotAuth\IndexController@test')->name('test_page');
