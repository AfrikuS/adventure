@extends('layouts.app')

@section('title', 'Work - Team-Orders')
@section('head')
    @parent
@endsection

@section('center')

    Список заказов на постройку.
    Чтобы принять заказ надо состоять в команде private-team
    <p></p>
    Все заказы

    @if(count($orders) > 0)
        <table class="table table-condensed">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>desc</th>
                    {{--<th>kind_work</th>--}}
                    <th>price</th>
                    <th>acceptor</th>
                    <th>type</th>
                    <th>status</th>
                    <th>show</th>
                    <th>del</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>
                            {!! Form::open(['route' => 'work_accept_teamorder_action', 'class' => 'form-signup']) !!}
                            {!! Form::hidden('order_id', $order->id, []) !!}
                            {!! Form::submit('Accept', array('class' => 'btn btn-primary')) !!}
                            {!! Form::close() !!}
                        </td>
{{--                        <td>{{ $order->desc }}</td>--}}
                        {{--<td>{{ $order->kind_work }}</td>--}}
                        <td>{{ $order->price }}</td>
{{--                        <td>{{ $order->team->creator->name | 'no' }}</td>--}}
                        <td>{{ $order->acceptor_team_id | 'no' }}</td>
                        <td>{{ $order->type }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ link_to_route('work_show_teamorder_page', 'Выбрать', ['id' => $order->id]) }}</td>
                        <td>{{ link_to_route('work_delete_teamorder_action', 'Del', ['id' => $order->id]) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </table>
    @else
        <p>Заказов сейчас нет

    @endif

    <p><p>Ваши заказы
    <p>
    @if(count($workerTeamOrders) > 0)
        <table class="table table-condensed">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>kind_work</th>
                    <th>price</th>
                    <th>acceptor_team_id</th>
                    <th>status</th>
                    <th>show</th>
                    <th>del</th>
                </tr>
                </thead>
                <tbody>
                @foreach($workerTeamOrders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->kind_work }}</td>
                        <td>{{ $order->price }}</td>
                        {{--                        <td>{{ $order->team->creator->name | 'no' }}</td>--}}
{{--                        <td>{{ $order->acceptor_team_id | 'no' }}</td>--}}
                        <td>{{ $order->acceptor_team_id }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ link_to_route('work_show_teamorder_page', 'Выбрать', ['id' => $order->id]) }}</td>
                        <td>{{ link_to_route('work_delete_teamorder_action', 'Del', ['id' => $order->id]) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </table>
    @else
        <p>Заказов сейчас нет
    @endif



@endsection

@section('right_column')

    @parent

    {!! Form::open(['route' => 'generate_work_teamorder_action', 'class' => 'form-signup']) !!}
    {!! Form::submit('Сгенерить командный заказ', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

@endsection

