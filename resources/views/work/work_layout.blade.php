@extends('layouts.app')


@section('left_column')

    <dl>
        <dt>Profile LINKS</dt>
        <dd>{{ link_to_route('work_shop_page', 'Shop') }}</dd>
        <dd>{{ link_to_route('work_orders_page', 'Orders list') }}</dd>
        <dd>{{ link_to_route('work_teamorders_page', 'TeamOrders list') }}</dd>
        {{--    <dd>{{ link_to_route('work_mine_page', 'Работы под добыче ресурсов') }}</dd>--}}
        <dd>{{ link_to_route('work_show_privateteam_page', 'My TEam', ['id' => 1]) }}</dd>
    </dl>
    <dl>
        <dt>TEAMS</dt>
        <dd>{{ link_to_route('work_privateteams_page', 'Teams LIST') }}</dd>
    </dl>

@endsection


@section('right_column')
    {{--Mine-ресурсы--}}
    {{--<ul>--}}
        {{--<li>Нефть: {{ $miner->petrol }}</li>--}}
        {{--<li>Керосин: {{ $miner->kerosene }}</li>--}}
        {{--<li>Масло: {{ $miner->oil }}</li>--}}
        {{--<li>Вода: {{ $miner->whater }}</li>--}}
    {{--</ul>--}}
@endsection
