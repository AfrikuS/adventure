@extends('layouts.app')

@section('title', 'DockMarket -> Geo')
@section('head')
    @parent
@endsection

@section('center')

    Торговые палатки проходящих торговых кораблей. Указано время до их отплытия
    <p><p><p>

    @if(count($shops) > 0)
        <table class="table table-condensed">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>LOT ID</th>
                    <th>destination</th>
                    {{--<th>resource_code</th>--}}
                    <th>date_sending</th>
                    <th>Cмотреть товары</th>
                    {{--<th>Действие</th>--}}
                </tr>
                </thead>
                <tbody>
                @foreach($shops as $shop)
                    <tr>
                        <td>{{ $shop->id }}</td>
                        <td>$shop->destination->title</td>
                        {{--<td>{{ $ship->resource_code }}</td>--}}
                        <td><div class="timer" data-seconds-left={{ $shop->duration_seconds }}></div></td>
                        <td>{{ link_to_route('geo_travel_ship_shop_page', 'Выбрать', ['id' => $shop->id]) }}</td>
                        {{--                        <td>{{ link_to_route('sea_delete_travel_action', 'Del', ['id' => $ship->id]) }}</td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </table>
    @else
        Палаток нет
    @endif

    <p></p>
    Спец-заказы на штучный товар


@endsection