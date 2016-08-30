@extends('geo.business._layout')

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
                - start point - ALWAYS current location
                <br>

            </div>

            <div class="col-lg-8">
                <div class="row row-offcanvas">

                    <div class="col-lg-4">
                        <p></p>

                        Draft routes
                        @foreach($draftRoutes as $draftRoute)
                            <p></p>
                            {{ link_to_route('geo_route_build_page', $draftRoute->title, ['id' => $draftRoute->id]) }}

                        @endforeach

                    </div>

                    <div class="col-lg-4">
                        <p>{!! Form::open(['route' => 'geo_set_ship_on_route_action']) !!}
                        Committed Маршруты
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
                    <div class="col-lg-4">

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
                        <p>{!! Form::submit('Поставить на рейс') !!}
                            {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>

        <div class="row row-offcanvas">
            <div class="col-lg-4">


            </div>

            <div class="col-lg-8">
                {{ HTML::image('images/modules/geo/sea-freights.png', 'a picture', ['class' => 'img-responsive']) }}

                <p></p>
                <p></p>
                Корабли, ожидающие отплытия\погрузки в порту
                <p>
                <ul>
                    @foreach($voyages as $voyage)
                        <li>
                            {{ $voyage->id }} - {{ $voyage->route_title }} - {{ $voyage->status }}
                            ->  {{ $voyage->point_location_title }}

                            @include('_partials.geo.business.voyages.action')

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


