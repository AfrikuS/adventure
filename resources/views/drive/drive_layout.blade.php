@extends('layouts.app')


@section('left_column')

    <ul>
        <li>Drive LINKS</li>
        <li>{{ link_to_route('drive_garage_vehicle_page', 'Garage-Vehicle') }}</li>
        <li>{{ link_to_route('drive_garage_repair_page', 'Garage-Repair') }}</li>
        <li>{{ link_to_route('drive_garage_shop_page', 'Garage-Shop') }}</li>
        <p>
        <li>{{ link_to_route('drive_service_station_page', 'Pit-Stop') }}</li>
    </ul>

@endsection


@section('right_column')

    @parent

    Driver Info
    {{--<p>--}}
        {{--Worker INFO--}}
    {{--<p>--}}


@endsection
