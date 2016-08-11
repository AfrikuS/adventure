<?php

Route::get('/learn', 'Learn\LearnController@index')->name('learn_page');
Route::post('/learn/learn', 'Learn\LearnController@learn')->name('learn_learn_action');
Route::post('/learn/restore_default', 'Learn\LearnController@restoreDefault')->name('learn_restore_default_action');


/*
Route::get('/railway/trades', 'Railway\LazyTradeController@index')->name('railway_trades_page');
Route::post('/railway/trades/add', 'Railway\LazyTradeController@add')->name('railway_trades_add_action');
Route::post('/railway/trades/take', 'Railway\LazyTradeController@take')->name('railway_trades_take_action');

Route::post('/railway/trades/reindexPrices', 'Railway\LazyTradeController@reindexPrices')->name('railway_reindex_prices_action');






Route::get('/railway/station', 'Railway\StationController@index')->name('railway_trains_page');
Route::post('/railway/station/generate_train', 'Railway\StationController@generateTrain')->name('railway_generate_train_action');
Route::post('/railway/station/delete_old_trains', 'Railway\StationController@deleteOlds')->name('railway_delete_old_trains_action');



Route::post('/railway/train/meeting_with_conductor', 'Railway\StationController@goToTrainConductor')->name('meeting_with_conductor_action');


Route::group(['middleware' => 'railway_train_meeting'], function () {

    Route::get('/railway/train', 'Railway\Train\TrainController@index')->name('railway_train_page');
    
    Route::get('/railway/meeting', 'Railway\Train\MeetingController@index')->name('railway_train_conductor_page');

    Route::post('/railway/train/conductor/take_bribe', 'Railway\Train\ConductorController@takeRegularBribe')->name('railway_conductor_take_bribe_action');
    Route::post('/railway/train/conductor/take_thanks', 'Railway\Train\ConductorController@takeBonusThanksBribe')->name('railway_conductor_take_thanks_action');
    Route::post('/railway/train/conductor/take_remain', 'Railway\Train\ConductorController@takeRarelyThing')->name('railway_conductor_take_remains_action');

    Route::post('/railway/station/train', 'Railway\Train\TrainController@connect')->name('railway_station_connect_train_action');
    Route::post('/railway/station/train/drain_oil', 'Railway\Train\DrainController@oil')->name('railway_station_drain_oil_action');
    Route::post('/railway/station/train/drain_petrol', 'Railway\Train\DrainController@petrol')->name('railway_station_drain_petrol_action');

    Route::post('/railway/train/depart', 'Railway\Train\TrainController@depart')->name('railway_depart_train_action');
    
});*/
