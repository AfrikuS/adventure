<?php



// battle-module
Route::get('/search', 'Battle\Controllers\AttackController@searchPage')->name('search_page');
Route::post('/search', 'Battle\Controllers\AttackController@searchOpponent')->name('search_enemy_action');
Route::post('/attack', 'Battle\Controllers\AttackController@attack')->name('attack_enemy_action');

Route::get('/bodalka', 'Battle\Controllers\BodalkaController@index')->name('bodalka_page');
Route::post('/bodalka', 'Battle\Controllers\BodalkaController@start')->name('bodalka_start_action');

Route::get('/boss', 'Battle\Controllers\BossController@index')->name('boss_page');
Route::post('/boss_create', 'Battle\Controllers\BossController@boss_create')->name('boss_create_action');
Route::post('/boss_join', 'Battle\Controllers\BossController@boss_join')->name('boss_join_action');
Route::post('/boss_kick', 'Battle\Controllers\BossController@boss_kick')->name('boss_kick_action');


