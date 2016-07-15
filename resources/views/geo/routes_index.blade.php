@extends('geo._layout')


@section('title', 'Geo - Locations -> Main Map')
@section('head')
    @parent
@endsection

@section('center')

    {{ link_to_route('geo_index_page', 'На главную Порта') }}
    <p></p>
    <h4>Редактор маршрута грузоперевозок</h4>

    <div class="row row-offcanvas">
        <div class="col-lg-4">

            <p>{!! Form::open(['route' => 'geo_delete_lastpoint_action', 'class' => '']) !!}
            <p>{!! Form::hidden('route_id', $route->id) !!}
            <p>{!! Form::submit('Delete last point') !!}
            <p>{!! Form::close() !!}

            <p></p><p></p>

            <p>{!! Form::open(['route' => 'geo_final_route_action', 'class' => '']) !!}
            <p>{!! Form::hidden('route_id', $route->id) !!}
            <p>{!! Form::submit('Final Route') !!}
            <p>{!! Form::close() !!}

            <p></p><p></p>

            <p>{!! Form::open(['route' => 'geo_create_voyage_action', 'class' => '']) !!}
            <p>{!! Form::hidden('route_id', $route->id) !!}
            <p>{!! Form::submit('Create Voyage by this Route') !!}
            <p>{!! Form::close() !!}



        </div>

        <div class="col-lg-8">
            Points
            @if($route->points->count() > 0)
                <table class="table table-condensed">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>location_id</th>
                            <th>number</th>
                            <th>status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($route->points as $point)
                            <tr>
                                <td>{{ $point->location->title }}</td>
                                <td>{{ $point->number }}</td>
                                <td>{{ $point->status }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </table>
            @endif

            <h4>Add Route-Point</h4>
            <p>{!! Form::open(['route' => 'geo_add_routepoint_action', 'class' => '']) !!}
            <p>{!! Form::hidden('route_id', $route->id) !!}
            <p>{!! Form::select('location_id', $possibleLocationsSelect) !!}
            <p>{!! Form::submit('Add route point') !!}
            {!! Form::close() !!}

        </div>
    </div>


    <div class="row row-offcanvas">
        <div class="col-lg-12">
            @if(count($locationsTableRows) > 0)
                <table class="table table-condensed">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Location</th>
                            <th>next_paths</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($locationsTableRows as $locId => $locationData)
                            <tr>
                                <td>{{ $locationData['title'] }}</td>
                                <td>
                                    <ul>
                                        @foreach($locationData['next_locations_title'] as $title)
                                            <li>{{ $title }}</li>
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

            <p></p>
        </div>
    </div>


@endsection
