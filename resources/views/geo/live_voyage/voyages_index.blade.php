@extends('geo._layout')

@section('title', 'Geo - Locations -> Main Map')
@section('head')
    @parent
@endsection

@section('center')

    <div class="row row-offcanvas">
        <div class="col-lg-12">
            <ul>
                <li>{{ link_to_route('geo_travels_page', 'Рейсы \ Отправления') }}</li>
                <li>{{ link_to_route('geo_index_page', 'Порт - Главная') }}</li>
                <li>{{ link_to_route('geo_live_voyage_page', 'Live Travels (new)') }}</li>
            </ul>

            <p></p>
            <h4>Список локаций \ Карта</h4>
            <p></p>
            @if($locations->count() > 0)
                <table class="table table-condensed">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Location</th>
                            <th>next_paths</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($locations as $location)
                            <tr>
                                <td>{{ $location->title }}</td>
                                <td>
                                    <ul>
                                        @foreach($location->locationsTo as $nextLocation)
                                            <li>{{ $nextLocation->title }}</li>
                                        @endforeach
                                    </ul>
                                </td>
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
        <div class="col-lg-12">
            Куда поплывем?
            <p><p><p>
            <table class="table table-condensed">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Текущее место</th>
                        <th>Поплывем в</th>
                        <th>Action</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $currentLocation->title }}</td>
                            <td>
                                <ul>
                                    @foreach($currentLocation->locationsTo as $nextLocation)
                                        <li>{{ $nextLocation->title }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                {!! Form::open(['route' => 'geo_live_sail_to_action', 'class' => '']) !!}
                                {!! Form::select('next_id', $possibleLocationsSelect) !!}
                            </td>
                            <td>
                                {!! Form::submit('Плывем!') !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </table>

        </div>
    </div>


    <div class="row row-offcanvas">
        <div class="col-lg-12">
            После прибытия в новый порт - можно зайти в магазин, там другие товары, другие цены и т.п.
        </div>
    </div>

@endsection
