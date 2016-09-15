<?php



// business

// VOYAGES
Route::get('/geo/business/voyages', 'Geo\Http\Controllers\Business\Voyages\VoyagesController@index')->name('geo_travels_page');
Route::post('/geo/business/bind_ship_route', 'Geo\Http\Controllers\Business\Voyages\VoyagesController@createVoyage')->name('geo_set_ship_on_route_action');

Route::post('/geo/create_voyage', 'Geo\Http\Controllers\Business\Voyages\VoyagesController@createVoyage')->name('geo_create_voyage_action');
//Route::post('/geo/voyage_start_voyage', 'Geo\Http\Controllers\Business\Voyages\VoyagesController@startVoyage')->name('geo_voyage_start_voyage_action');
Route::post('/geo/voyage_sail', 'Geo\Http\Controllers\Business\Voyages\VoyagesController@sail')->name('geo_voyage_sail_action');
Route::post('/geo/voyage_moor', 'Geo\Http\Controllers\Business\Voyages\VoyagesController@moor')->name('geo_voyage_moor_action');

Route::get('/geo/business/sea_freights', 'Geo\Http\Controllers\Business\Voyages\SeaFreightsController@index')->name('geo_sea_freights_page');
Route::post('/geo/business/generate_ship', 'Geo\Http\Controllers\Business\Voyages\SeaFreightsController@generateShip')->name('geo_generate_ship_action');


// VOYAGE ROUTES
Route::get('/geo/build_route/{id}', 'Geo\Http\Controllers\Business\Voyages\TravelRouteController@editRoute')->name('geo_route_build_page');
Route::post('/geo/create_route', 'Geo\Http\Controllers\Business\Voyages\TravelRouteController@createRoute')->name('geo_add_route_action');
Route::post('/geo/add_routepoint', 'Geo\Http\Controllers\Business\Voyages\TravelRouteController@addRoutePoint')->name('geo_add_routepoint_action');
Route::post('/geo/delete_lastpoint', 'Geo\Http\Controllers\Business\Voyages\TravelRouteController@deleteLastpoint')->name('geo_delete_lastpoint_action');
Route::post('/geo/commit_route', 'Geo\Http\Controllers\Business\Voyages\TravelRouteController@commitRoute')->name('geo_final_route_action');
Route::post('/geo/uncommit_route', 'Geo\Http\Controllers\Business\Voyages\TravelRouteController@uncommitRoute')->name('geo_uncommit_route_action');


