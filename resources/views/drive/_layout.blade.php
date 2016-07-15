@extends('layouts.app')


@section('left_column')

    <ul>
        <li>Drive LINKS</li>
        <li>{{ link_to_route('drive_garage_vehicle_page', 'Garage-Vehicle') }}</li>
        <li>{{ link_to_route('drive_garage_shop_page', 'Garage-Shop') }}</li>
        <p></p>
        <li>{{ link_to_route('drive_workroom_page', 'Мастерская') }}</li>
        <li><b>{{ link_to_route('drive_vehicle_equip_to_raid_page', 'Подготовиться к рейду') }}</b></li>
    </ul>

@endsection


@section('right_column')

    @parent

    Vehicle Info
    <p></p>
    State: {{ $vehicle->state }}
    <p></p>damage: {{ $vehicle->damage_percent }} %
    <p></p>
    <p></p>
    <ul>
        <li>acceleration: {{ $vehicle->acceleration }}</li>
        <li>stability:    {{ $vehicle->stability }}</li>
        <li>mobility:     {{ $vehicle->mobility }}</li>
        <li>fuel:         {{ $vehicle->fuel_level }}</li>
    </ul>
    <p></p>
    <p></p>

    {{--@if($raid != null)--}}
        {{--{{ link_to_route('drive_raid_page', 'Рейд') }}--}}
    {{--@endif--}}


@endsection
