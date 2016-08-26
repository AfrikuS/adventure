<?php

Route::get('/npc/show_offer/{id}', 'Npc\Controllers\OfferController@index')->name('npc_show_offer_page');
Route::get('/npc/show_reward/{id}', 'Npc\Controllers\OfferController@showReward')->name('npc_show_reward_page');

Route::post('/npc/offer/accept', 'Npc\Controllers\OfferController@acceptOffer')->name('npc_accept_offer_page');
Route::post('/npc/offer/refuse', 'Npc\Controllers\OfferController@refuseOffer')->name('npc_refuse_offer_action');



Route::get('/npc/show_deal/{id}', 'Npc\Controllers\DealController@index')->name('npc_show_deal_page');
//Route::get('/npc/show_deal/{id}', 'Npc\Controllers\OfferController@showDeal')->name('npc_show_deal_page');

Route::post('/npc/deal/perform', 'Npc\Controllers\DealController@performDeal')->name('npc_perform_deal_action');
Route::post('/npc/deal/{id}/take_reward', 'Npc\Controllers\DealController@takeReward')->name('npc_take_reward_page');
Route::post('/npc/deal/generate_offer', 'Npc\Controllers\OfferController@generateOffer')->name('npc_generate_offer_action');









Route::get('/admin/npc', 'Admin\Npc\CharactersController@index')->name('admin_module_npc_page');
Route::get('/admin/npc/characters', 'Admin\Npc\CharactersController@index')->name('npc_characters_page');
Route::post('/admin/npc/add_character', 'Admin\Npc\CharactersController@add')->name('create_npc_character_action');



