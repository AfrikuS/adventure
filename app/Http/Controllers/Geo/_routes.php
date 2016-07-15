<?php

// geo-module
Route::get('/geo/', 'Geo\PortController@index')->name('geo_index_page');


Route::get('/geo/director', 'Geo\DirectorController@index')->name('geo_director_page');




Route::get('/geo/ship_shops', 'Geo\DockMarketController@index')->name('geo_dock_market_page');
Route::get('/geo/shipshop/{id}', 'Geo\DockMarketController@shipShop')->name('geo_travel_ship_shop_page');
Route::post('/geo/travel/ship_create_order', 'Geo\TravelController@createOrder')->name('travelship_create_order_action');
Route::post('/geo/shipshop/buy_material', 'Geo\DockMarketController@buyMaterial')->name('travelship_buy_material_action');


Route::get('/geo/travel', 'Geo\TravelController@index')->name('geo_travels_page');

Route::get('/geo/live_voyage', 'Geo\LiveVoyageController@index')->name('geo_live_voyage_page');
Route::post('/geo/live_voyage_sail_to', 'Geo\LiveVoyageController@sailTo')->name('geo_live_sail_to_action');



Route::get('/geo/build_route/{id}', 'Geo\TravelRouteController@editRoute')->name('geo_route_build_page');
Route::post('/geo/create_route', 'Geo\TravelRouteController@createRoute')->name('geo_add_route_action');
Route::post('/geo/add_routepoint', 'Geo\TravelRouteController@addRoutePoint')->name('geo_add_routepoint_action');
Route::post('/geo/delete_lastpoint', 'Geo\TravelRouteController@deleteLastpoint')->name('geo_delete_lastpoint_action');
Route::post('/geo/commit_route', 'Geo\TravelRouteController@commitRoute')->name('geo_final_route_action');

Route::get('/geo/business', 'Geo\Business\TraderController@profile')->name('geo_business_page');
Route::get('/geo/business/tempo_shops', 'Geo\Business\TempoShopController@index')->name('geo_trader_temposhops_page');
Route::get('/geo/business/tempo_shop/{id}', 'Geo\Business\TempoShopController@show')->name('geo_trader_show_temposhop_page');
Route::post('/geo/business/add_tempo_shop', 'Geo\Business\TempoShopController@addTempoShop')->name('geo_generate_temposhop_action');

Route::get('/geo/business/sea_freights', 'Geo\Business\SeaFreightsController@index')->name('geo_sea_freights_page');
Route::post('/geo/business/generate_ship', 'Geo\Business\ShipController@generateShip')->name('geo_generate_ship_action');
Route::post('/geo/business/bind_ship_route', 'Geo\Business\ShipController@setShipOnRoute')->name('geo_set_ship_on_route_action');

Route::post('/geo/create_voyage', 'Geo\Business\VoyageController@createVoyage')->name('geo_create_voyage_action');
Route::post('/geo/voyage_start_voyage', 'Geo\Business\VoyageController@startVoyage')->name('geo_voyage_start_voyage_action');
Route::post('/geo/voyage_sail', 'Geo\Business\VoyageController@sail')->name('geo_voyage_sail_action');
Route::post('/geo/voyage_moor', 'Geo\Business\VoyageController@moor')->name('geo_voyage_moor_action');

Route::post('/geo/travel/create_order', 'Geo\TravelController@createOrder')->name('sea_create_order_action');


// fixture methods
Route::post('/generate/geo/travel', 'DataGeneratorController@generateTravel')->name('sea_generate_travel_action');
Route::get('/delete/geo/travel/{id}', 'DataGeneratorController@deleteTravel')->name('sea_delete_travel_action');


// inner-api
Route::get('api/geo/locations', 'Api\Geo\LocationsController@locations')->name('api_geo_locations');
    
