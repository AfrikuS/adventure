@extends('geo.business._layout')

@section('title', 'Sea -> Voyages Port')
@section('head')
    @parent
@endsection

@section('center')

    <p></p>
    Список кораблей, уходящих в дальние страны.
    <p>Можно заказать привезти оттуда разных ресов
    <p></p>
    <b>Дела внешней торговли</b>
    <p></p>
    <b>Актуальные предложения от заморских NPC</b>
    <p></p>



    <p></p><p></p>

    Таблица рейсов \ отправлений в дальние страны
    <p></p>

    @if(count($voyages) > 0)
        <table class="table table-condensed">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>route_id</th>
                    <th>point_id</th>
                    <th>location_id</th>
                    <th>status</th>
                    {{--<th>Покупка</th>--}}
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($voyages as $voyage)
                    <tr>
                        <td>{{ $voyage->id }}</td>
                        <td>{{ link_to_route('geo_route_build_page', $voyage->route_title, ['id' => $voyage->route_id]) }}</td>
                        <td>{{ $voyage->point_id }}</td>
                        <td>{{ $voyage->point_location_title }}</td>
                        <td>{{ $voyage->status }}</td>
                        <td>
                            {!! Form::open(['route' => 'geo_voyage_sail_action', 'class' => '']) !!}
                            {!! Form::hidden('voyage_id', $voyage->id) !!}
                            {!! Form::submit('Just Плыть') !!}
                            {!! Form::close() !!}
                            {!! Form::open(['route' => 'geo_voyage_moor_action', 'class' => '']) !!}
                            {!! Form::hidden('voyage_id', $voyage->id) !!}
                            {!! Form::submit('Just Причалить') !!}
                            {!! Form::close() !!}
                        </td>
                        {{--<td>{{ link_to_route('sea_create_order_page', 'Выбрать', ['id' => $voyage->id]) }}</td>--}}
                        {{--<td>{{ link_to_route('sea_delete_travel_action', 'Del', ['id' => $voyage->id]) }}</td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </table>
    @else
        Рейсов нет
    @endif

@endsection

@section('right_column')

    @parent


@endsection

