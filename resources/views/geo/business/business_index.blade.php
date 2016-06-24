@extends('layouts.app')

@section('title', 'Geo - Business')
@section('head')
    @parent
@endsection

@section('center')

        <div class="row row-offcanvas">
            <div class="col-lg-6">
                <h4>Создать Маршрут для грузоперевозок</h4>
                <p>{!! Form::open(['route' => 'geo_add_route_action', 'class' => '']) !!}
                <p>{!! Form::text('title', '', ['placeholder' => 'маршрут']) !!}
                <p>{!! Form::label('start_location', 'Начальный пункт') !!}
                <p>{!! Form::select('start_location_id', $locationsSelect) !!}
                <p>{!! Form::submit('Add route') !!}
                {!! Form::close() !!}
                <p></p>
            </div>

            <div class="col-lg-6">
                Маршруты
                <p>
                <ul>
                    @foreach($routes as $route)
                        <li>{{ link_to_route('geo_route_build_page', $route->title, ['id' => $route->id]) }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="row row-offcanvas">
            <div class="col-lg-4">

            </div>

            <div class="col-lg-8">
                <p><p>
                    Рейсы по маршрутам (состояние, положение на карте)
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

