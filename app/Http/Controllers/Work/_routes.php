<?php

Route::get('/work', 'Work\WorkController@index')->name('work_index_page');



Route::get('/work/orders', 'Work\OrdersController@index')->name('work_orders_page');
Route::get('/work/orders/ajax/{chunk_number}', 'Api\Work\AjaxComponentsController@orderLoading')->name('work_orders_ajax_page');
// single-order actions

/*
Route::get('/work/order/{id}', 'Work\Order\OrderController@index')->name('work_show_order_page');
Route::post('/work/orders/accept', 'Work\Order\OrderController@accept')->name('work_accept_order_action');
Route::post('/work/order/estimate', 'Work\Order\OrderController@estimate')->name('work_order_estimate_action');
Route::post('/work/order/add_material', 'Work\Order\OrderController@stockMaterial')->name('work_order_add_material_in_stock_action');
Route::post('/work/order/apply_skill', 'Work\Order\OrderController@applySkill')->name('work_order_apply_skill_action');
Route::post('/work/order/delete', 'Work\Order\OrderController@delete')->name('work_delete_order_action');
Route::post('/work/order/generate', 'Work\Order\OrderController@generate')->name('generate_work_order_action');
Route::post('/work/order/cancel_skill', 'Work\Order\OrderController@cancelSkill')->name('work_order_cancel_apply_skill_action');
*/






// team-order actions
Route::get('/work/teamorders', 'Work\TeamOrdersController@index')->name('work_teamorders_page');


Route::get('/work/teamorder/{id}', 'Work\Order\TeamOrderController@index')->name('work_show_teamorder_page');

Route::post('/work/teamorder/accept', 'Work\Order\TeamOrderController@acceptOrder')->name('work_accept_teamorder_action');
Route::post('/work/teamorder/estimate', 'Work\Order\TeamOrderController@estimate')->name('work_teamorder_estimate_action');
Route::post('/work/teamorder/add_material', 'Work\Order\TeamOrderController@addMaterial')->name('work_teamorder_add_material_in_stock_action');
Route::post('/work/teamorder/apply_skill', 'Work\Order\TeamOrderController@applySkill')->name('work_teamorder_apply_skill_in_stock_action');
Route::post('/work/teamorder/take_reward', 'Work\Order\TeamOrderController@takeReward')->name('work_teamorder_take_reward_action');
Route::get('/work/teamorder/delete/{id}', 'Work\Order\TeamOrderController@delete')->name('work_delete_teamorder_action');


//    });


//    Route::group(['middleware' => 'work_teamorder_partner'], function () {
//    });

