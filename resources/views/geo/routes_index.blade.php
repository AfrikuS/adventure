@extends('layouts.app')

@section('title', 'Geo - Locations -> Main Map')
@section('head')
    @parent
@endsection

@section('center')

    <div class="row row-offcanvas">
        <div class="col-lg-12">
            {{ link_to_route('geo_map_page', 'All Locations') }}
            <p></p>
            <h4>Список локаций и путей между ними</h4>
            <p></p>
            @if(count($locsView) > 0)
                <table class="table table-condensed">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Location</th>
                            <th>next_paths</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($locsView as $locId => $locationData)
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
        </div>
    </div>

    <div class="row row-offcanvas">
        <div class="col-lg-4">

            <p>{!! Form::open(['route' => 'geo_delete_lastpoint_action', 'class' => '']) !!}
            <p>{!! Form::hidden('route_id', $route->id) !!}
            <p>{!! Form::submit('Delete last point') !!}
            {!! Form::close() !!}

        </div>

        <div class="col-lg-8">
            Points
            @if(count($routePoints) > 0)
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
                        @foreach($routePoints as $point)
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
            <p>{!! Form::submit('Add route') !!}
            {!! Form::close() !!}

        </div>
    </div>




@endsection
