@extends('geo._layout')

@section('left_column')

    @parent

    <p></p>

    <b>Личное дело</b>
    <p></p>

    <ul>
    <li>{{ link_to_route('geo_sea_freights_page', 'Sea freights \ Морские грузоперевозки') }}</li>
    <li>{{ link_to_route('geo_travels_page', 'Рейсы \ Отправления') }}</li>
    <li>{{ link_to_route('geo_live_voyage_page', 'Live Travels (new)') }}</li>
    </ul>

@endsection