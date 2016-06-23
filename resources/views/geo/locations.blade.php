@extends('layouts.app')

@section('title', 'Geo - Locations -> Main Map')
@section('head')
    @parent
@endsection

@section('center')

    <div class="row row-offcanvas">
        <div class="col-lg-12">
            <ul>
                <li>{{ link_to_route('geo_travels_page', 'Рейсы \ Отправления') }}</li>
                <li>{{ link_to_route('geo_map_page', 'Локации \ Карта') }}</li>
                <li>{{ link_to_route('geo_live_voyage_page', 'Live Travels (new)') }}</li>
            </ul>

            <p></p>
            <h4>Список локаций и путей между ними</h4>
            <p></p>
            @if(count($locationsTableRows) > 0)
                <table class="table table-condensed">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Location</th>
                            <th>next_paths</th>
                            <th>add_next</th>
                            <th>action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($locationsTableRows as $locId => $locationColumns)
                            <tr>
                                <td>{{ $locationColumns['title'] }}</td>
                                <td>
                                    <ul>
                                        @foreach($locationColumns['nextLocationsTitles'] as $nextTitle)
                                            <li>{{ $nextTitle }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                @if (count($locationColumns['otherLocations']) > 0)
                                    <td>
                                        {!! Form::open(['route' => 'geo_bind_locations_action', 'class' => '']) !!}
                                        {!! Form::hidden('location_id', $locId) !!}
                                        {!! Form::select('next_location_id', $locationColumns['otherLocations']) !!}
                                    </td>
                                    <td>
                                        {!! Form::submit('Add') !!}
                                        {!! Form::close() !!}
                                    </td>
                                @else
                                    <td></td>
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </table>
            @else
                Локаций нет
            @endif
        </div>
    </div>

    <div class="row row-offcanvas">
        <div class="col-lg-8">
        </div>

        <div class="col-lg-4">
            <p></p>
            <h4>Создать Location</h4>
            {!! Form::open(['route' => 'geo_add_location_action', 'class' => '']) !!}
            {!! Form::text('title', 'Новая_') !!}
            {!! Form::submit('Add') !!}
            {!! Form::close() !!}
        </div>
    </div>

    <div class="row row-offcanvas">
        <div class="col-lg-4">
            <h4>Создать Route</h4>
            <p>{!! Form::open(['route' => 'geo_add_route_action', 'class' => '']) !!}
            <p>{!! Form::text('title', 'Маршрут_') !!}
            <p>{!! Form::label('start_location', 'Начальный пункт') !!}
            <p>{!! Form::select('start_location_id', $locationsSelect) !!}
            <p>{!! Form::submit('Add route') !!}
            {!! Form::close() !!}
            <p></p>

        </div>
        <div class="col-lg-4">
            Маршруты
            <p>
            <ul>
                @foreach($routes as $route)
                    <li>{{ link_to_route('geo_route_build_page', $route->title, ['id' => $route->id]) }}</li>
                @endforeach
            </ul>
        </div>

        <div class="col-lg-4">
            <p><p>
                Рейсы \ Voyages
            <p>
            <ul>
                @foreach($voyages as $voyage)
                    <li>
                        {{ $voyage->id }} - {{ $voyage->route->title }} - {{ $voyage->status }}
                        ->  {{ $voyage->point->location->title }}

                    {!! Form::open(['route' => 'geo_voyage_start_sail_action', 'class' => '']) !!}
                    {!! Form::hidden('voyage_id', $voyage->id) !!}
                    {!! Form::submit('Start sail') !!}
                    {!! Form::close() !!}
                    {!! Form::open(['route' => 'geo_voyage_moor_action', 'class' => '']) !!}
                    {!! Form::hidden('voyage_id', $voyage->id) !!}
                    {!! Form::submit('Причалить') !!}
                    {!! Form::close() !!}

                </li>
                @endforeach
            </ul>
        </div>
    </div>




@endsection
