<?php


// geo-module
Route::get('/geo/', 'Geo\Http\Controllers\Harbour\HarbourController@index')->name('geo_index_page');


//Route::get('/geo/director', 'Geo\Hnamespace App\Modules\Geo\Http\Controllers\Business;
Route::get('/geo/director', 'Geo\Http\Controllers\DirectorController@index')->name('geo_director_page');




Route::get('/geo/ship_shops', 'Geo\Http\Controllers\DockMarketController@index')->name('geo_dock_market_page');
Route::get('/geo/shipshop/{id}', 'Geo\Http\Controllers\DockMarketController@shipShop')->name('geo_travel_ship_shop_page');
Route::post('/geo/travel/ship_create_order', 'Geo\Http\Controllers\TravelController@createOrder')->name('travelship_create_order_action');
Route::post('/geo/shipshop/buy_material', 'Geo\Http\Controllers\DockMarketController@buyMaterial')->name('travelship_buy_material_action');








Route::get('/geo/business', 'Geo\Http\Controllers\Business\BusinessController@profile')->name('geo_business_page');
Route::get('/geo/business/tempo_shops', 'Geo\Http\Controllers\Business\TempoShopController@index')->name('geo_trader_temposhops_page');
Route::get('/geo/business/tempo_shop/{id}', 'Geo\Http\Controllers\Business\TempoShopController@show')->name('geo_trader_show_temposhop_page');
Route::post('/geo/business/add_tempo_shop', 'Geo\Http\Controllers\Business\TempoShopController@addTempoShop')->name('geo_generate_temposhop_action');


Route::post('/geo/travel/create_order', 'Geo\Http\Controllers\TravelController@createOrder')->name('sea_create_order_action');


// fixture methods
//Route::post('/generate/geo/travel', 'DataGeneratorController@generateTravel')->name('sea_generate_travel_action');
//Route::get('/delete/geo/travel/{id}', 'DataGeneratorController@deleteTravel')->name('sea_delete_travel_action');


// inner-api
Route::get('api/geo/locations', 'Api\Geo\LocationsController@locations')->name('api_geo_locations');






// CRUISE

Route::get('/geo/harbour/cruise', 'Geo\Http\Controllers\Harbour\CruiseController@index')->name('geo_live_voyage_page');
Route::post('/geo/harbour/cruise/sail_to', 'Geo\Http\Controllers\Harbour\CruiseController@sailTo')->name('geo_live_sail_to_action');


