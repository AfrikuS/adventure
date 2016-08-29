<?php


// geo-module
Route::get('/geo/', 'Geo\Http\Controllers\Harbour\HarbourController@index')->name('geo_index_page');


//Route::get('/geo/director', 'Geo\Hnamespace App\Modules\Geo\Http\Controllers\Business;
Route::get('/geo/director', 'Geo\Http\Controllers\DirectorController@index')->name('geo_director_page');




Route::get('/geo/ship_shops', 'Geo\Http\Controllers\DockMarketController@index')->name('geo_dock_market_page');
Route::get('/geo/shipshop/{id}', 'Geo\Http\Controllers\DockMarketController@shipShop')->name('geo_travel_ship_shop_page');
Route::post('/geo/travel/ship_create_order', 'Geo\Http\Controllers\TravelController@createOrder')->name('travelship_create_order_action');
Route::post('/geo/shipshop/buy_material', 'Geo\Http\Controllers\DockMarketController@buyMaterial')->name('travelship_buy_material_action');





Route::get('/geo/build_route/{id}', 'Geo\Http\Controllers\Business\TravelRouteController@editRoute')->name('geo_route_build_page');
Route::post('/geo/create_route', 'Geo\Http\Controllers\Business\TravelRouteController@createRoute')->name('geo_add_route_action');
Route::post('/geo/add_routepoint', 'Geo\Http\Controllers\Business\TravelRouteController@addRoutePoint')->name('geo_add_routepoint_action');
Route::post('/geo/delete_lastpoint', 'Geo\Http\Controllers\Business\TravelRouteController@deleteLastpoint')->name('geo_delete_lastpoint_action');
Route::post('/geo/commit_route', 'Geo\Http\Controllers\Business\TravelRouteController@commitRoute')->name('geo_final_route_action');
Route::post('/geo/uncommit_route', 'Geo\Http\Controllers\Business\TravelRouteController@uncommitRoute')->name('geo_uncommit_route_action');




Route::get('/geo/business', 'Geo\Http\Controllers\Business\BusinessController@profile')->name('geo_business_page');
Route::get('/geo/business/tempo_shops', 'Geo\Http\Controllers\Business\TempoShopController@index')->name('geo_trader_temposhops_page');
Route::get('/geo/business/tempo_shop/{id}', 'Geo\Http\Controllers\Business\TempoShopController@show')->name('geo_trader_show_temposhop_page');
Route::post('/geo/business/add_tempo_shop', 'Geo\Http\Controllers\Business\TempoShopController@addTempoShop')->name('geo_generate_temposhop_action');

Route::get('/geo/business/sea_freights', 'Geo\Http\Controllers\Business\SeaFreightsController@index')->name('geo_sea_freights_page');
Route::post('/geo/business/generate_ship', 'Geo\Http\Controllers\Business\SeaFreightsController@generateShip')->name('geo_generate_ship_action');
Route::post('/geo/business/bind_ship_route', 'Geo\Http\Controllers\Business\VoyagesController@createVoyage')->name('geo_set_ship_on_route_action');

Route::post('/geo/create_voyage', 'Geo\Http\Controllers\Business\VoyagesController@createVoyage')->name('geo_create_voyage_action');
//Route::post('/geo/voyage_start_voyage', 'Geo\Http\Controllers\Business\VoyagesController@startVoyage')->name('geo_voyage_start_voyage_action');
Route::post('/geo/voyage_sail', 'Geo\Http\Controllers\Business\VoyagesController@sail')->name('geo_voyage_sail_action');
Route::post('/geo/voyage_moor', 'Geo\Http\Controllers\Business\VoyagesController@moor')->name('geo_voyage_moor_action');

Route::post('/geo/travel/create_order', 'Geo\Http\Controllers\TravelController@createOrder')->name('sea_create_order_action');


// fixture methods
//Route::post('/generate/geo/travel', 'DataGeneratorController@generateTravel')->name('sea_generate_travel_action');
//Route::get('/delete/geo/travel/{id}', 'DataGeneratorController@deleteTravel')->name('sea_delete_travel_action');


// inner-api
Route::get('api/geo/locations', 'Api\Geo\LocationsController@locations')->name('api_geo_locations');



// business

// VOYAGES
Route::get('/geo/business/voyages', 'Geo\Http\Controllers\Business\VoyagesController@index')->name('geo_travels_page');




// CRUISE

Route::get('/geo/harbour/cruise', 'Geo\Http\Controllers\Harbour\CruiseController@index')->name('geo_live_voyage_page');
Route::post('/geo/harbour/cruise/sail_to', 'Geo\Http\Controllers\Harbour\CruiseController@sailTo')->name('geo_live_sail_to_action');






// admin-geo
Route::get('/admin/locations', 'Geo\Http\Controllers\Admin\LocationsEditorController@index')->name('admin_locations_page');
Route::post('/admin/bind_locations', 'Geo\Http\Controllers\Admin\LocationsEditorController@bind')->name('admin_bind_locations_action');
Route::post('/admin/add_location', 'Geo\Http\Controllers\Admin\LocationsEditorController@addLocation')->name('admin_add_location_action');

Route::get('/admin/rm_path/{from_id}/{to_id}', 'Geo\Http\Controllers\Admin\LocationsEditorController@removePath')->name('geo_rm_location_path_action');
