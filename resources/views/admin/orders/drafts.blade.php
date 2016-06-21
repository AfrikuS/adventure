@extends('layouts.app')

@section('title', 'Orders-Constructor/ Order-Drafts - Admin Page')
@section('head')
    @parent
@endsection

@section('center')

    <div class="row row-offcanvas">
        <h4>Заказы-черновики</h4>
        <div class="col-lg-12">

            Список заготовок заказов
            <p></p>

            @if(count($draftOrders) > 0)
                <table class="table table-condensed">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>desc</th>
                            <th>kind_work</th>
                            <th>price</th>
                            <th>status</th>
                            <th>show</th>
                            <th>del</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($draftOrders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->desc }}</td>
                                <td>{{ $order->kind_work }}</td>
                                <td>{{ $order->price }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ link_to_route('admin_edit_orderdraft_1_page', 'Выбрать', ['id' => $order->id]) }}</td>
                                <td>{{ link_to_route('work_delete_order_action', 'Del', ['id' => $order->id]) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </table>
            @else
                Заготовок нет
            @endif
            <p></p>

        </div>
    </div>

    <div class="row row-offcanvas">
        <div class="col-lg-4">
            <h4>Создать SingleOrder</h4>
        </div>
        <div class="col-lg-4">
            <h4>Создать TeamOrder</h4>
        </div>
        <div class="col-lg-4">
            <h4>Создать ComplexOrder</h4>
        </div>
        <div class="col-lg-4">
            <h4>Создать XZ-kakoi-Order</h4>
        </div>
    </div>

@endsection
