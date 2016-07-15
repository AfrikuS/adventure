@extends('layouts.app')


@section('left_column')

    <ul>
        <li>Profile LINKS</li>
        <li>{{ link_to_route('work_shop_page', 'Shop') }}</li>
        <li>{{ link_to_route('work_orders_page', 'Orders list') }}</li>
        <li>{{ link_to_route('work_teamorders_page', 'TeamOrders list') }}</li>
        {{--    <li>{{ link_to_route('work_mine_page', 'Работы под добыче ресурсов') }}</li>--}}
        <li>{{ link_to_route('work_show_privateteam_page', 'My TEam', ['id' => 1]) }}</li>
    </ul>
    <ul>
        <li>TEAMS</li>
        <li>{{ link_to_route('work_privateteams_page', 'Teams LIST') }}</li>
    </ul>

@endsection


@section('right_column')

    @parent

    {{--Team Info--}}
    {{--<p>--}}
    {{--@if ($worker['team_id'] == null)--}}
        {{--Вы не состоите в группе--}}
    {{--@else--}}
        {{--{{ link_to_route('work_show_privateteam_page', 'Ваша группа', ['id' => $worker['team_id']]) }}--}}
    {{--@endif--}}

    {{--<p>--}}
    {{--<p>--}}
    {{--Worker INFO--}}
    {{--<p>--}}


@endsection
