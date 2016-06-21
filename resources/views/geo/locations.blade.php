@extends('layouts.app')

@section('title', 'Geo - Locations -> Main Map')
@section('head')
    @parent
@endsection

@section('center')

    <div class="row row-offcanvas">
        <div class="col-lg-12">
            <h4>Список локаций и путей между ними</h4>
            <p></p>
            @if(count($locsView) > 0)
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
                        @foreach($locsView as $locId => $locationData)
                            <tr>
                                <td>{{ $locationData['title'] }}</td>
                                <td>
                                    <ul>
                                        @foreach($locationData['next_ids'] as $path_id)
                                            <li>{{ $path_id }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                @if (count($locationData['locs_select']) > 0)
                                    <td>
                                        {!! Form::open(['route' => 'geo_bind_locations_action', 'class' => '']) !!}
                                        {!! Form::hidden('location_id', $locId) !!}
                                        {!! Form::select('next_location_id', $locationData['locs_select']) !!}
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
        <div class="col-lg-12">
            
        </div>
    </div>




@endsection
