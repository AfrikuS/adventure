@extends('admin.admin_layout')

@section('title', 'Orders-Constructor/ Order-Drafts - Admin Page')
@section('head')
    @parent
@endsection

@section('center')

    <div class="row row-offcanvas">
        <h4>Заказы-черновики (don't use)</h4>
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
                            <th>price</th>
                            <th>type</th>
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
                                <td>{{ $order->price }}</td>
                                <td>{{ $order->type }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ link_to_route('teamorder_draft_select_requires_page', 'Изменить', ['id' => $order->id]) }}</td>

                                <td>
                                    {!! Form::open(['route' => 'teamorder_draft_delete_action', 'class' => '']) !!}
                                    {!! Form::hidden('draft_id', $order->id) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-success']) !!}
                                    {!! Form::close() !!}

                                </td>
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
            {!! Form::open(['route' => 'teamorder_draft_create_action', 'class' => '']) !!}
            {!! Form::submit('Create Team-Order', ['class' => 'btn btn-success']) !!}
            {!! Form::close() !!}
        </div>
        <div class="col-lg-4">
            <h4>Создать ComplexOrder</h4>
        </div>
        <div class="col-lg-4">
            <h4>Создать XZ-kakoi-Order</h4>
        </div>
    </div>

@endsection
