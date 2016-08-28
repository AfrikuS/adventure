<?php

// auction module
Route::get('/auction', 'Auction\Http\Controllers\AuctionController@index')->name('auction_page');
Route::post('/auction/add_lot', 'Auction\Http\Controllers\AuctionController@addLot')->name('auction_add_lot_action');
Route::post('/auction/buy', 'Auction\Http\Controllers\AuctionController@buy')->name('auction_buy_lot_action');

Route::get('/auction/cancel/{id}', 'Auction\Http\Controllers\AuctionController@cancel')->name('auction_cancel_lot_action');
