@extends('layouts.app')

@section('title', 'Sea -> Travel Port')
@section('head')
    @parent
@endsection

@section('center')

    Список кораблей, уходящих в дальние страны.
    <p>Можно заказать привезти оттуда разных ресов
    <p></p>

    @if(count($travelShips) > 0)
        <table class="table table-condensed">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>LOT ID</th>
                    <th>destination</th>
                    <th>resource_code</th>
                    <th>date_sending</th>
                    <th>Покупка</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody>
                @foreach($travelShips as $ship)
                    <tr>
                        <td>{{ $ship->id }}</td>
                        <td>{{ $ship->destination }}</td>
                        <td>{{ $ship->resource_code }}</td>
                        <td><div class="timer" data-seconds-left={{ $ship->duration_seconds }}></div></td>
                        <td>{{ link_to_route('sea_create_order_page', 'Выбрать', ['id' => $ship->id]) }}</td>
                        <td>{{ link_to_route('sea_delete_travel_action', 'Del', ['id' => $ship->id]) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </table>
    @else
        Кораблей нет
    @endif

@endsection

@section('right_column')

    @parent
    Таймеры по заказам
    <p>
    @if(count($ordersTimers) > 0)
        <ul>
            @foreach($ordersTimers as $timer)
                <li><div class="timer" data-seconds-left={{ $timer->duration_seconds }}></div></li>
            @endforeach
        </ul>
    @endif

    <p></p>
    <p></p>

    {!! Form::open(['route' => 'sea_generate_travel_action', 'class' => 'form-signup']) !!}
    {!! Form::submit('Сгенерить тревел', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

@endsection

