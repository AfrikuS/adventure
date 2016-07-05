@extends('layouts.app')

@section('title', 'Geo - Business')
@section('head')
    @parent
@endsection

@section('center')

        <div class="row row-offcanvas">
            <div class="col-lg-4">
                <h4>Создать Маршрут</h4>
                <p>{!! Form::open(['route' => 'geo_add_route_action']) !!}
                <p>{!! Form::text('title', '', ['placeholder' => 'маршрут']) !!}
                <p>{!! Form::label('start_location', 'Начальный пункт') !!}
                <p>{!! Form::select('start_location_id', $locationsSelect) !!}
                <p>{!! Form::submit('Add route') !!}
                {!! Form::close() !!}
                <p></p>
            </div>

            <div class="col-lg-8">
                <div class="row row-offcanvas">
                    <div class="col-lg-6">
                        <p>{!! Form::open(['route' => 'geo_set_ship_on_route_action']) !!}
                        Маршруты
                        <p>
                        <ul>
                            @foreach($routes as $route)
                                <li>
                                    {{ Form::radio('route_id', $route->id, false, []) }}
                                    {{ link_to_route('geo_route_build_page', $route->title, ['id' => $route->id]) }}
                                </li>

                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-6">

                        Корабли
                        <p>
                        <ul>
                            @forelse($ships as $ship)
                                <li>
                                    {{ Form::radio('ship_id', $ship->id, false, []) }}
                                    Ship -> {{ $ship->id }}
                                </li>
                            @empty
                                Кораблей нет
                            @endforelse
                        </ul>
                        <p>{!! Form::submit('Поставить') !!}
                            {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>

        <div class="row row-offcanvas">
            <div class="col-lg-4">
                {{ link_to_route('geo_business_page', 'Back to kabinet') }}
                <p></p>
            </div>

            <div class="col-lg-8">
                Мониторинг кораблей в рейсе/ Управление кораблем:
                <p>плыть к следующему пункту, начать торговлю \ закончить - плыть назад, заполнить трюмы?
                всё через state-machine
                <p><p>
                    Рейсы по маршрутам (состояние, положение на карте)
                <p>
                <ul>
                    @foreach($voyages as $voyage)
                        <li>
                            {{ $voyage->id }} - {{ $voyage->route->title }} - {{ $voyage->status }}
                            ->  {{ $voyage->point->location->title }}

                        {!! Form::open(['route' => 'geo_voyage_start_voyage_action', 'class' => '']) !!}
                        {!! Form::hidden('voyage_id', $voyage->id) !!}
                        {!! Form::submit('Start voyage') !!}
                        {!! Form::close() !!}
                        {{--<p></p>--}}
                        {!! Form::open(['route' => 'geo_voyage_moor_action', 'class' => '']) !!}
                        {!! Form::hidden('voyage_id', $voyage->id) !!}
                        {!! Form::submit('Причалить') !!}
                        {!! Form::close() !!}
                        {!! Form::open(['route' => 'geo_voyage_sail_action', 'class' => '']) !!}
                        {!! Form::hidden('voyage_id', $voyage->id) !!}
                        {!! Form::submit('В плавание') !!}
                        {!! Form::close() !!}

                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

@endsection

@section('right_column')

    @parent

    {!! Form::open(['route' => 'geo_generate_ship_action', 'class' => 'form-signup']) !!}
    {!! Form::submit('Add ship', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

@endsection


