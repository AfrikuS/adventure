<?php

Route::get('/npc/show_offer/{id}', 'Npc\NpcDealController@showOffer')->name('npc_show_offer_page');
Route::get('/npc/show_deal/{id}', 'Npc\NpcDealController@showDeal')->name('npc_show_deal_page');
Route::get('/npc/show_reward/{id}', 'Npc\NpcDealController@showReward')->name('npc_show_reward_page');

Route::post('/npc/offer/accept', 'Npc\NpcDealController@acceptOffer')->name('npc_accept_offer_page');
Route::post('/npc/offer/refuse', 'Npc\NpcDealController@refuseOffer')->name('npc_refuse_offer_page');

Route::post('/npc/deal/perform', 'Npc\NpcDealController@performDeal')->name('npc_perform_deal_action');
Route::post('/npc/deal/{id}/take_reward', 'Npc\NpcDealController@takeReward')->name('npc_take_reward_page');
Route::post('/npc/deal/generate_offer', 'Npc\NpcDealController@generateOffer')->name('npc_generate_offer_page');
