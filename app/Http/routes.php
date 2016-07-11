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


    Route::get('/work', 'Work\WorkController@index')->name('work_index_page');
    Route::get('/delete/work/order/{id}', 'Work\OrderController@deleteOrder')->name('work_delete_order_action');
    Route::post('/generate/work/order', 'Work\OrderController@generateOrder')->name('generate_work_order_action');



    Route::get('/work/orders', 'Work\OrderController@index')->name('work_orders_page');
    Route::get('/work/orders/ajax/{chunk_number}', 'Api\Work\AjaxComponentsController@orderLoading')->name('work_orders_ajax_page');
    // single-order actions
    Route::post('/work/order/accept', 'Work\OrderController@acceptOrder')->name('work_accept_order_action');
//    Route::group(['middleware' => 'work_order_acceptor'], function () {
        Route::get('/work/order/{id}', 'Work\OrderController@showOrder')->name('work_show_order_page');
        Route::post('/work/order/add_material', 'Work\OrderController@addMaterial')->name('work_order_add_material_in_stock_action');
        Route::post('/work/order/apply_skill', 'Work\OrderController@applySkill')->name('work_order_apply_skill_action');
        Route::post('/work/order/estimate', 'Work\OrderController@estimate')->name('work_order_estimate_action');
//    });

    
    
    // team-order actions
    Route::get('/work/teamorders', 'Work\Team\TeamOrderController@index')->name('work_teamorders_page');
//    Route::group(['middleware' => 'work_teamorder_acceptor'], function () {
        Route::post('/work/teamorder/accept', 'Work\Team\TeamOrderController@acceptOrder')->name('work_accept_teamorder_action');
    Route::get('/delete/work/teamorder/{id}', 'Work\Team\TeamOrderController@deleteTeamOrder')->name('work_delete_teamorder_action');
    Route::post('/work/teamorder/estimate', 'Work\Team\TeamOrderController@estimate')->name('work_teamorder_estimate_action');
    Route::post('/work/teamorder/take_reward', 'Work\Team\TeamOrderController@takeReward')->name('work_teamorder_take_reward_action');
    
    
//    });
    
    
//    Route::group(['middleware' => 'work_teamorder_partner'], function () {
        Route::get('/work/teamorder/{id}', 'Work\Team\TeamOrderController@showOrder')->name('work_show_teamorder_page');
        Route::post('/work/teamorder/add_material', 'Work\Team\TeamOrderController@addMaterial')->name('work_teamorder_add_material_in_stock_action');
        Route::post('/work/teamorder/apply_skill', 'Work\Team\TeamOrderController@applySkill')->name('work_teamorder_apply_skill_in_stock_action');
//    });

    Route::get('/work/teams', 'Work\Team\PrivateTeamController@index')->name('work_privateteams_page');

//    Route::group(['middleware' => 'work_worker_belong_team'], function () {
        Route::get('/work/teams/{id}', 'Work\Team\PrivateTeamController@showPrivateTeam')->name('work_show_privateteam_page');
        Route::post('/work/teams/leave_team', 'Work\Team\PrivateTeamController@leavePrivateTeam')->name('work_leave_privateteam_action');
        Route::post('/work/teams/offer_join', 'Work\Team\PrivateTeamController@offerJoin')->name('work_privateteam_offerjoin_action');
        Route::post('/work/team/accept_joinoffer', 'Work\Team\TeamLeaderController@acceptJoinOffer')->name('work_team_accept_offer_action');
        Route::post('/work/team/refuse_joinoffer', 'Work\Team\TeamLeaderController@refuseJoinOffer')->name('work_team_refuse_offer_action');
    //    });
    
    Route::group(['middleware' => 'work_worker_one_leader'], function () {
        Route::get('/work/create_privateteam', 'Work\Team\PrivateTeamController@createPrivateteam')->name('work_create_privateteam_page');
        Route::post('/work/create_privateteam', 'Work\Team\PrivateTeamController@createPrivateteamAction')->name('work_create_privateteam_action');
    });

    Route::group(['middleware' => 'work_leader_team'], function () {
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
    Route::get('/admin/', 'Admin\AdminController@index')->name('admin_index_page');
    Route::get('/admin/module/work', 'Admin\AdminController@work')->name('admin_module_work_page');




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

    // admin-geo
    Route::get('/admin/locations', 'Admin\Geo\LocationsEditorController@index')->name('admin_locations_page');
    Route::post('/admin/bind_locations', 'Admin\Geo\LocationsEditorController@bind')->name('admin_bind_locations_action');
    Route::post('/admin/add_location', 'Admin\Geo\LocationsEditorController@addLocation')->name('admin_add_location_action');




    // geo-module
    Route::get('/geo/', 'Geo\GeoController@index')->name('geo_index_page');

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

    Route::post('/generate/work/teamorder', 'DataGeneratorController@generateWorkTeamOrder')->name('generate_work_teamorder_action');

    Route::post('/generate/work/create_material', 'Admin\Work\CatalogsController@createMaterial')->name('create_work_material_action');
    Route::post('/generate/work/create_skill', 'Admin\Work\CatalogsController@createSkill')->name('create_work_skill_action');
    Route::post('/generate/work/create_instrument', 'Admin\Work\CatalogsController@createInstrument')->name('create_work_instrument_action');

    Route::get('/admin/drive', 'Admin\Drive\CatalogsController@index')->name('admin_module_drive_page');
    Route::post('/generate/drive/create_detail_kind', 'Admin\Drive\CatalogsController@createDetailKind')->name('create_detail_kind_action');
    Route::post('/generate/drive/create_detail_title', 'Admin\Drive\CatalogsController@createDetailTitle')->name('create_detail_title_action');


    // inner-api
    Route::get('api/geo/locations', 'Api\Geo\LocationsController@locations')->name('api_geo_locations');
    
    

    // OTHER / mass-actions on socket.io
    Route::get('/maxovik', 'Mass\MaxovikController@index')->name('maxovik_page');
});


