@extends('layouts.app')

@section('left_column')

    <ul>
        <li>Railway LINKS</li>
        <p></p>
        <li>{{ link_to_route('railway_director_page', 'Управляющий Ж\Д') }}</li>
        <li>{{ link_to_route('railway_trades_page', 'Lazy Trades') }}</li>
        {{--<p></p>--}}
        <li>{{ link_to_route('railway_trains_page', 'Transit Trains') }}</li>
        {{--<li><b>{{ link_to_route('drive_vehicle_equip_to_raid_page', 'Подготовиться к рейду') }}</b></li>--}}
    </ul>

@endsection
