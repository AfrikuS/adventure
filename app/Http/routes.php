<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'app_auth'], function () {

//    Route::get('/profile', 'Profile\ProfileController@index')->name('profile_page');
//    Route::get('/profile/channels', 'Profile\ProfileController@channels')->name('profile_channels_page');


    // work-module
    Route::get('/mine', 'Mine\MineController@index')->name('mine_index_page');
    Route::post('/mine/mine_petrol', 'Mine\OilController@minePetrol')->name('mine_mine_petrol_action');
    Route::post('/mine/mine_kerosene', 'Mine\OilController@mineKerosene')->name('mine_mine_kerosene_action');
    Route::post('/mine/mine_oil', 'Mine\OilController@mineOil')->name('mine_mine_oil_action');
    Route::post('/mine/mine_whater', 'Mine\OilController@mineWhater')->name('mine_mine_whater_action');
//    Route::get('/work/mine/create_teamwork', 'Work\MineController@createSingleTeamWork')->name('work_create_single_teamwork_page');
//    Route::post('/work/mine/commit_privateteam_action', 'Work\TeamworksController@commitPrivateteamAction')->name('work_commit_privateteam_action');
//    Route::post('/work/mine/ready_to_teamwork_action', 'Work\TeamworksController@readyToTeamworkAction')->name('work_ready_to_teamwork_action');
//    Route::get('/work/mine/privateteamworks/{id}', 'Work\TeamworksController@showTeamWork')->name('work_show_teamwork_page');
//
//
//    Route::get('/work/mine/team_work_conditions/{offer_id}', 'Work\MineController@teamWorkConditions')->name('work_show_teamwork_conditions_page');
//    Route::post('/work/mine/delete_teamwork', 'Work\MineController@teamWorkDelete')->name('work_delete_single_teamwork_action');
//    Route::post('/work/mine/join_to_teamwork', 'Work\MineController@joinToTeamWork')->name('work_join_to_teamwork_action');
//    Route::post('/work/mine/create_teamwork', 'Work\MineController@createTeamWork')->name('work_create_teamwork_action');
//    Route::post('/work/mine', 'Work\MineController@mine')->name('work_mine_action');




    // macro-module
    Route::get('/macro', 'Macro\PoliticController@index')->name('macro_page');
    Route::get('/macro/obtain', 'Macro\ObtainController@index')->name('macro_obtain_page');
    Route::get('/macro/buildings', 'Macro\BuildingController@index')->name('macro_buildings_page');
    Route::get('/macro/buildings/{id}', 'Macro\BuildingController@show')->name('macro_buildings_smith');
    Route::post('/macro/buildings/smithWork', 'Macro\BuildingController@smithWork')->name('building_smith_work_action');
    Route::get('/macro/exchange', 'Macro\ExchangeController@index')->name('macro_exchange_page');
    Route::post('/macro/exchange/change', 'Macro\ExchangeController@change');
    Route::post('/macro/exchange/offer', 'Macro\ExchangeController@offer');
    
    Route::post('/macro/equip', 'Macro\BuildingController@equip');
    Route::post('/macro/food', 'Macro\ObtainController@obtainFood');
    Route::post('/macro/build', 'Macro\BuildingController@build');
    Route::post('/macro/profession', 'Macro\PoliticController@learnProfession')->name('politic_learn_profession');


    // admin
    Route::get('/admin/', 'Admin\AdminController@index')->name('admin_index_page');




    // team-order-constructor
    Route::get('/admin/orders_drafts', 'Admin\OrderBuilder\TeamOrderBuilderController@orderDrafts')->name('admin_orderdrafts_page');


    Route::get('/admin/order_builder/team_order/main/{id}', 'Admin\OrderBuilder\TeamOrderBuilderController@mainTeamOrderDraft')->name('teamorder_draft_main_page');
    Route::post('/admin/order_builder/team_order/create', 'Admin\OrderBuilder\TeamOrderBuilderController@createOrderDraft')->name('teamorder_draft_create_action');


    Route::get('/admin/order_builder/selectRequirements/{id}', 'Admin\OrderBuilder\TeamOrderBuilderController@selectRequirements')->name('teamorder_draft_select_requires_page');
    Route::get('/admin/order_builder/settingValues/{id}', 'Admin\OrderBuilder\TeamOrderBuilderController@settingValues')->name('teamorder_draft_setting_page');
    
    Route::post('/admin/order_builder/team_order/update_materials', 'Admin\OrderBuilder\TeamOrderBuilderController@setRequirements')->name('teamorder_draft_recheck_action');
    Route::post('/admin/edit_orderdraft_2', 'Admin\OrderBuilder\TeamOrderBuilderController@fillValues')->name('teamorder_draft_fill_action');
    Route::post('/admin/publish_orderdraft', 'Admin\OrderBuilder\TeamOrderBuilderController@publish')->name('admin_publish_orderdraft_action');
    Route::post('/admin/order_builder/delete_draft', 'Admin\OrderBuilder\TeamOrderBuilderController@deleteDraft')->name('teamorder_draft_delete_action');






    
    
    
    
    



    Route::post('/generate/work/teamorder', 'DataGeneratorController@generateWorkTeamOrder')->name('generate_work_teamorder_action');


//    Route::get('/admin/drive', 'Admin\Drive\CatalogsController@index')->name('admin_module_drive_page');
//    Route::post('/generate/drive/create_detail_kind', 'Admin\Drive\CatalogsController@createDetailKind')->name('create_detail_kind_action');
//    Route::post('/generate/drive/create_detail_title', 'Admin\Drive\CatalogsController@createDetailTitle')->name('create_detail_title_action');
//

    

    // OTHER / mass-actions on socket.io
    Route::get('/maxovik', 'Mass\MaxovikController@index')->name('maxovik_page');
});


