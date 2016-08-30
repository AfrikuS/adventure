<?php




// admin-geo
Route::get('/admin/locations', 'Geo\Http\Controllers\Admin\LocationsEditorController@index')->name('admin_locations_page');
Route::post('/admin/bind_locations', 'Geo\Http\Controllers\Admin\LocationsEditorController@bind')->name('admin_bind_locations_action');
Route::post('/admin/add_location', 'Geo\Http\Controllers\Admin\LocationsEditorController@addLocation')->name('admin_add_location_action');

Route::get('/admin/rm_path/{from_id}/{to_id}', 'Geo\Http\Controllers\Admin\LocationsEditorController@removePath')->name('geo_rm_location_path_action');
