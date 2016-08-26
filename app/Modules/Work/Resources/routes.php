<?php




Route::get('/work/orders', 'Work\Controllers\Order\OrdersController@index')->name('work_orders_page');


Route::get('/work/order/{id}', 'Work\Controllers\Order\OrderController@index')->name('work_show_order_page');
Route::post('/work/orders/accept', 'Work\Controllers\Order\OrderController@accept')->name('work_accept_order_action');
Route::post('/work/order/estimate', 'Work\Controllers\Order\OrderController@estimate')->name('work_order_estimate_action');
Route::post('/work/order/add_material', 'Work\Controllers\Order\OrderController@stockMaterial')->name('work_order_add_material_in_stock_action');
Route::post('/work/order/apply_skill', 'Work\Controllers\Order\OrderController@applySkill')->name('work_order_apply_skill_action');
Route::post('/work/order/delete', 'Work\Controllers\Order\OrderController@delete')->name('work_delete_order_action');
Route::post('/work/order/generate', 'Work\Controllers\Order\OrderController@generate')->name('generate_work_order_action');
Route::post('/work/order/cancel_skill', 'Work\Controllers\Order\OrderController@cancelSkill')->name('work_order_cancel_apply_skill_action');


Route::post('/work/generate_order', 'Work\Controllers\Order\OrdersController@generateOrder')->name('work_create_build_order_action');


// admin
Route::get('/admin/module/work', 'Work\Controllers\Admin\Catalogs\CatalogsController@index')->name('admin_module_work_page');

Route::post('/generate/work/create_material', 'Work\Controllers\Admin\Catalogs\CatalogsController@createMaterial')->name('create_work_material_action');
Route::post('/generate/work/create_skill', 'Work\Controllers\Admin\Catalogs\CatalogsController@createSkill')->name('create_work_skill_action');
Route::post('/generate/work/create_instrument', 'Work\Controllers\Admin\Catalogs\CatalogsController@createInstrument')->name('create_work_instrument_action');


// shop
Route::get('/work/shop', 'Work\Controllers\Shop\ShopController@index')->name('work_shop_page');
Route::get('/work/shop/instruments', 'Work\Controllers\Shop\ShopController@instruments')->name('work_shop_instruments_page');
Route::post('/work/shop/buy_material', 'Work\Controllers\Shop\ShopController@buyMaterial')->name('work_shop_buy_material_action');
Route::post('/work/shop/buy_instrument', 'Work\Controllers\Shop\ShopController@buyInstrument')->name('work_shop_buy_instrument_action');

Route::post('/work/shop/reindex', 'Work\Controllers\Shop\ShopController@updateMaterialsPrices')->name('work_shop_reindex_prices_action');
Route::post('/work/shop/update_instruments_prices', 'Work\Controllers\Shop\ShopController@updateInstrumentsPrices')->name('update_instruments_prices_action');



// team sub-module
Route::get('/work/teams', 'Work\Controllers\Team\TeamsController@index')->name('work_privateteams_page');

//Route::group(['middleware' => 'work_worker_one_leader'], function () {
    Route::get('/work/create_privateteam', 'Work\Controllers\Team\TeamsController@createPrivateteam')->name('work_create_privateteam_page');
    Route::post('/work/create_privateteam', 'Work\Controllers\Team\TeamsController@createTeam')->name('work_create_privateteam_action');
//});






//    Route::group(['middleware' => 'work_worker_belong_team'], function () {
Route::get('/work/teams/{id}', 'Work\Controllers\Team\TeamController@index')->name('work_show_privateteam_page');
Route::post('/work/teams/leave_team', 'Work\Controllers\Team\PartnerController@leavePrivateTeam')->name('work_leave_privateteam_action');
Route::post('/work/teams/offer_join', 'Work\Controllers\Team\TeamController@offerJoin')->name('work_privateteam_offerjoin_action');
Route::post('/work/team/accept_joinoffer', 'Work\Controllers\Team\LeaderController@acceptJoinOffer')->name('work_team_accept_offer_action');
Route::post('/work/team/refuse_joinoffer', 'Work\Controllers\Team\LeaderController@refuseJoinOffer')->name('work_team_refuse_offer_action');
//    });


//Route::group(['middleware' => 'work_leader_team'], function () {
    Route::post('/work/delete_privateteam_action', 'Work\Controllers\Team\LeaderController@deleteTeam')->name('work_delete_privateteam_action');
//});


