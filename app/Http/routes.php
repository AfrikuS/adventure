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

    Route::get('/profile', 'Profile\ProfileController@index')->name('profile_page');
    Route::get('/profile/channels', 'Profile\ProfileController@channels')->name('profile_channels_page');


    // work-module
//    Route::get('/work/mine', 'Work\MineController@index')->name('work_mine_page');
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


    Route::get('/work', 'Work\WorkController@index')->name('work_index_page');


    Route::get('/work/orders', 'Work\OrderController@index')->name('work_orders_page');
    // single-order actions
    Route::group(['middleware' => 'work_order_acceptor'], function () {
        Route::get('/work/order/{id}', 'Work\OrderController@showOrder')->name('work_show_order_page');
        Route::post('/work/order/add_material', 'Work\OrderController@addMaterial')->name('work_order_add_material_in_stock_action');
        Route::post('/work/order/start_works', 'Work\OrderController@startWorks')->name('work_order_start_works_action');
    });

    Route::get('/work/teamorders', 'Work\Team\TeamOrderController@index')->name('work_teamorders_page');


    // team-order actions
    Route::group(['middleware' => 'work_teamorder_acceptor'], function () {
        Route::post('/work/teamorder/accept', 'Work\Team\TeamOrderController@acceptOrder')->name('work_accept_teamorder_page');
    });
    
    
    Route::group(['middleware' => 'work_teamorder_partner'], function () {
        Route::get('/work/teamorder/{id}', 'Work\Team\TeamOrderController@showOrder')->name('work_show_teamorder_page');
        Route::post('/work/teamorder/add_material', 'Work\Team\TeamOrderController@addMaterial')->name('work_teamorder_add_material_in_stock_action');
        Route::post('/work/teamorder/add_skill', 'Work\Team\TeamOrderController@addSkill')->name('work_teamorder_add_skill_in_stock_action');
    });

    Route::get('/work/privateteams', 'Work\Team\PrivateTeamController@index')->name('work_privateteams_page');

    Route::group(['middleware' => 'work_worker_belong_team'], function () {
        Route::get('/work/privateteams/{id}', 'Work\Team\PrivateTeamController@showPrivateTeam')->name('work_show_privateteam_page');
        Route::post('/work/privateteams/leave_privateteam', 'Work\Team\PrivateTeamController@leavePrivateTeam')->name('work_leave_privateteam_action');
    });
    
    Route::group(['middleware' => 'work_worker_one_leader'], function () {
        Route::get('/work/create_privateteam', 'Work\Team\PrivateTeamController@createPrivateteam')->name('work_create_privateteam_page');
        Route::post('/work/create_privateteam', 'Work\Team\PrivateTeamController@createPrivateteamAction')->name('work_create_privateteam_action');
    });

    Route::group(['middleware' => 'work_leader_team'], function () {
        Route::post('/work/add_partner_to_privateteam_action', 'Work\Team\PrivateTeamController@addPartnerToPrivateteamAction')->name('work_add_partner_to_privateteam_action');
        Route::post('/work/delete_privateteam_action', 'Work\Team\PrivateTeamController@deletePrivateteamAction')->name('work_delete_privateteam_action');
    });


    Route::get('/work/shop', 'Work\ShopController@index')->name('work_shop_page');
    Route::get('/work/shop/instruments', 'Work\ShopController@instruments')->name('work_shop_instruments_page');
    Route::post('/work/shop/reindex', 'Work\ShopController@reindexPrices')->name('work_shop_reindex_prices_action');
    Route::post('/work/shop/buy_material', 'Work\ShopController@buyMaterial')->name('work_shop_buy_material_action');
    Route::post('/work/shop/buy_instrument', 'Work\ShopController@buyInstrument')->name('work_shop_buy_instrument_action');



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
    Route::get('/admin', 'Admin\AdminController@index')->name('admin_page');



    Route::get('/', 'IndexController@index')->name('index_page');
    Route::get('/test', 'IndexController@test')->name('test_page');

    // team-order-constructor
    Route::get('/admin/orders', 'Admin\OrderBuilder\TeamOrderBuilderController@orderDrafts')->name('admin_orderdrafts_page');
    Route::get('/admin/create_order_draft_1', 'Admin\OrderBuilder\TeamOrderBuilderController@createOrderDraft')->name('admin_create_orderdraft_page');
    Route::get('/admin/edit_order_draft_1/{id}', 'Admin\OrderBuilder\TeamOrderBuilderController@editOrderDraft_1')->name('admin_edit_orderdraft_1_page');
    Route::get('/admin/edit_order_draft_2/{id}', 'Admin\OrderBuilder\TeamOrderBuilderController@editOrderDraft_2')->name('admin_edit_orderdraft_2_page');
    
    Route::post('/admin/create_orderdraft', 'Admin\OrderBuilder\TeamOrderBuilderController@createOrderDraft')->name('admin_create_orderdraft_action');
    Route::post('/admin/edit_orderdraft_1', 'Admin\OrderBuilder\TeamOrderBuilderController@editOrderDraftAction_1')->name('admin_edit_orderdraft_1_action');
    Route::post('/admin/edit_orderdraft_2', 'Admin\OrderBuilder\TeamOrderBuilderController@editOrderDraftAction_2')->name('admin_edit_orderdraft_2_action');
    Route::post('/admin/accept_orderdraft', 'Admin\OrderBuilder\TeamOrderBuilderController@acceptOrderDraft')->name('admin_accept_orderdraft_action');
    
    

    
    // geo-module
    Route::get('/geo/travel', 'Geo\TravelController@index')->name('geo_travels_page');

    Route::get('/geo/live_voyage', 'Geo\LiveVoyageController@index')->name('geo_live_voyage_page');
    Route::post('/geo/live_voyage_sail_to', 'Geo\LiveVoyageController@sailTo')->name('geo_live_sail_to_action');
    

    Route::get('/geo', 'Geo\LocationController@index')->name('geo_map_page');
    Route::get('/geo/location/{id}', 'Geo\LocationController@show')->name('geo_location_page');
    Route::post('/geo/bind_locations', 'Geo\LocationController@bind')->name('geo_bind_locations_action');
    Route::post('/geo/add_location', 'Geo\LocationController@addLocation')->name('geo_add_location_action');

    Route::get('/geo/build_route/{id}', 'Geo\TravelRouteController@buildRoute')->name('geo_route_build_page');
    Route::post('/geo/add_route', 'Geo\TravelRouteController@addRoute')->name('geo_add_route_action');
    Route::post('/geo/add_routepoint', 'Geo\TravelRouteController@addRoutePoint')->name('geo_add_routepoint_action');
    Route::post('/geo/delete_lastpoint', 'Geo\TravelRouteController@deleteLastpoint')->name('geo_delete_lastpoint_action');
    Route::post('/geo/final_route', 'Geo\TravelRouteController@finalRoute')->name('geo_final_route_action');

    Route::post('/geo/create_voyage', 'Geo\VoyageController@createVoyage')->name('geo_create_voyage_action');
    Route::post('/geo/voyage_start_sail', 'Geo\VoyageController@startSail')->name('geo_voyage_start_sail_action');
    Route::post('/geo/voyage_moor', 'Geo\VoyageController@moor')->name('geo_voyage_moor_action');
//    Route::resource('islands', 'Geo\IslandsController');
    Route::get('/geo/travel/order/{travel_id}', 'Geo\TravelController@showOrder')->name('sea_create_order_page');
    Route::post('/geo/travel/create_order', 'Geo\TravelController@createOrder')->name('sea_create_order_action');

    
    // battle-module
    Route::get('/search', 'Battle\AttackController@searchPage')->name('search_page');
    Route::post('/search', 'Battle\AttackController@searchOpponent')->name('search_enemy_action');
    Route::post('/attack', 'Battle\AttackController@attack')->name('attack_enemy_action');

    Route::get('/bodalka', 'Battle\BodalkaController@index')->name('bodalka_page');
    Route::post('/bodalka', 'Battle\BodalkaController@start')->name('bodalka_start_action');

    Route::get('/boss', 'Battle\BossController@index')->name('boss_page');
    Route::post('/boss_create', 'Battle\BossController@boss_create')->name('boss_create_action');
    Route::post('/boss_join', 'Battle\BossController@boss_join')->name('boss_join_action');
    Route::post('/boss_kick', 'Battle\BossController@boss_kick')->name('boss_kick_action');



    // trade module
    Route::get('/auction', 'Trade\AuctionController@index')->name('auction_page');
    Route::post('/auction/add_lot', 'Trade\AuctionController@addLot')->name('auction_add_lot_action');
    Route::post('/auction/buy', 'Trade\AuctionController@buy')->name('auction_buy_lot_action');

    // fixture methods
    Route::post('/generate/geo/travel', 'DataGeneratorController@generateTravel')->name('sea_generate_travel_action');
    Route::get('/delete/geo/travel/{id}', 'DataGeneratorController@deleteTravel')->name('sea_delete_travel_action');

    Route::post('/generate/work/order', 'DataGeneratorController@generateWorkOrder')->name('generate_work_order_action');
    Route::post('/generate/work/teamorder', 'DataGeneratorController@generateWorkTeamOrder')->name('generate_work_teamorder_action');

    Route::get('/delete/work/order/{id}', 'DataGeneratorController@deleteWorkOrder')->name('work_delete_order_action');
    Route::post('/generate/work/create_material', 'DataGeneratorController@createMaterial')->name('create_work_material_action');
    Route::post('/generate/work/create_skill', 'DataGeneratorController@createSkill')->name('create_work_skill_action');
    Route::post('/generate/work/create_instrument', 'DataGeneratorController@createInstrument')->name('create_work_instrument_action');
    Route::get('/delete/work/teamorder/{id}', 'DataGeneratorController@deleteWorkTeamOrder')->name('work_delete_teamorder_action');

    // inner-api
    Route::get('api/geo/locations', 'Api\Geo\LocationsController@locations')->name('api_geo_locations');
    
    

    // OTHER / mass-actions on socket.io
    Route::get('/maxovik', 'Mass\MaxovikController@index')->name('maxovik_page');
});


Route::get('/sign_in', 'Guest\GuestController@signIn')->name('sign_in_page');
Route::get('/sign_up', 'Guest\GuestController@signUp')->name('sign_up_page');
Route::get('/logout', 'Auth\UserController@logout')->name('logout_action');

Route::post('/login', 'Guest\GuestController@login')->name('sign_in_action');
Route::post('/register', 'Auth\UserController@register')->name('sign_up_action');
