<?php

// Home
use App\Models\Work\Order;
use App\Models\Work\Team\TeamOrder;

Breadcrumbs::register('index_page', function($breadcrumbs) {
    $breadcrumbs->push('Home', route('index_page'));
});

Breadcrumbs::register('work_index_page', function($breadcrumbs) {
    $breadcrumbs->parent('index_page');
    $breadcrumbs->push('Work_Index', route('work_index_page'));
});

    Breadcrumbs::register('work_shop_page', function($breadcrumbs) {
        $breadcrumbs->parent('work_index_page');
        $breadcrumbs->push('Shop_main', route('work_shop_page'));
    });
        Breadcrumbs::register('work_shop_instruments_page', function($breadcrumbs) {
            $breadcrumbs->parent('work_shop_page');
            $breadcrumbs->push('Shop_instruments', route('work_shop_instruments_page'));
        });

    Breadcrumbs::register('work_privateteams_page', function($breadcrumbs) {
        $breadcrumbs->parent('work_index_page');
        $breadcrumbs->push('Private Teams list', route('work_privateteams_page'));
    });

        Breadcrumbs::register('work_show_privateteam_page', function($breadcrumbs, $id) {
            $breadcrumbs->parent('work_privateteams_page');
            $breadcrumbs->push('Team # ' . $id, route('work_show_privateteam_page',  $id));
        });
        Breadcrumbs::register('work_create_privateteam_page', function($breadcrumbs) {
            $breadcrumbs->parent('work_privateteams_page');
            $breadcrumbs->push('Create own team', route('work_create_privateteam_page'));
        });



    Breadcrumbs::register('work_orders_page', function($breadcrumbs) {
        $breadcrumbs->parent('work_index_page');
        $breadcrumbs->push('Стол заказов', route('work_orders_page'));
    });

        Breadcrumbs::register('work_show_order_page', function($breadcrumbs, $id) {
            $order = Order::select('desc')->findOrFail($id);
            $breadcrumbs->parent('work_orders_page');
            $breadcrumbs->push($order->desc, route('work_show_order_page',  $id));
        });

    Breadcrumbs::register('work_teamorders_page', function($breadcrumbs) {
        $breadcrumbs->parent('work_index_page');
        $breadcrumbs->push('Стол командных заказов', route('work_teamorders_page'));
    });

        Breadcrumbs::register('work_show_teamorder_page', function($breadcrumbs, $id) {
            $order = TeamOrder::select('desc')->findOrFail($id);
            $breadcrumbs->parent('work_teamorders_page');
            $breadcrumbs->push($order->desc, route('work_show_teamorder_page',  $id));
        });






    Breadcrumbs::register('search_page', function($breadcrumbs) {
        $breadcrumbs->parent('index_page');
        $breadcrumbs->push('Поиск противника', route('search_page'));
    });

    Breadcrumbs::register('admin_page', function($breadcrumbs) {
        $breadcrumbs->parent('index_page');
        $breadcrumbs->push('Админка', route('admin_page'));
    });

    Breadcrumbs::register('macro_page', function($breadcrumbs) {
        $breadcrumbs->parent('index_page');
        $breadcrumbs->push('Макро-управление', route('macro_page'));
    });

        Breadcrumbs::register('macro_buildings_page', function($breadcrumbs) {
            $breadcrumbs->parent('macro_page');
            $breadcrumbs->push('Строительство', route('macro_buildings_page'));
        });

        Breadcrumbs::register('macro_exchange_page', function($breadcrumbs) {
            $breadcrumbs->parent('macro_page');
            $breadcrumbs->push('Обмен ресурсами', route('macro_exchange_page'));
        });

        Breadcrumbs::register('macro_obtain_page', function($breadcrumbs) {
            $breadcrumbs->parent('macro_page');
            $breadcrumbs->push('Добыча ресурсов', route('macro_obtain_page'));
        });

