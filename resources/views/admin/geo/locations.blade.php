@extends('layouts.app')

@section('title', 'Geo - Locations -> Main Map')
@section('head')
    @parent

    <link rel="stylesheet" href="{{ asset('js/alchemy-0.4.1/alchemy.css') }}">

    <script src="{{ asset('js/d3/d3.js') }}" charset="utf-8"></script>
    <script src="{{ asset('js/alchemy-0.4.1/scripts/vendor.js') }}"></script>
    <script src="{{ asset('js/alchemy-0.4.1/alchemy.js') }}"></script>
@endsection

@section('center')

    <div class="row row-offcanvas">
        <div class="col-lg-8">

            <p></p>
            <h4>Список локаций и путей между ними</h4>
            <p></p>
            <div id="alchemy" class="alchemy"></div>
        </div>
        <div class="col-lg-4">
            <p></p>
            <h4>Создать Location</h4>
            {!! Form::open(['route' => 'admin_add_location_action', 'class' => '']) !!}
            {!! Form::text('title', '', ['placeholder' => 'Новая_локация']) !!}
            {!! Form::submit('Add') !!}
            {!! Form::close() !!}
        </div>

    </div>

    <div class="row row-offcanvas">
        <div class="col-lg-12">
            <p></p>
            @if(count($locationsColl) > 0)
                <table class="table table-condensed">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Location</th>
                            <th>next_paths</th>
                            <th>add_next</th>
                            <th>action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($locationsColl as $location)
                            <tr>
                                <td>{{ $location->id }}</td>
                                <td>{{ $location->title }}</td>
                                <td>
                                    @foreach($location->nextLocations as $next)
                                        <br>{{ $next->title }} {{ link_to_route('geo_rm_location_path_action', 'X', [$location->id, $next->id]) }}
                                    @endforeach
                                </td>
                                @if (count($potentialsMap->get($location->id)) > 0)
                                    <td>
                                        {!! Form::open(['route' => 'admin_bind_locations_action', 'class' => '']) !!}
                                        {!! Form::hidden('location_id', $location->id) !!}
                                        {!! Form::select('next_location_id', $potentialsMap->getPotentialsViewSelect($location->id)) !!}
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


@endsection

@section('scripts')

    <script type="javascript">

    //alert();
    var some_data =
    {
    "nodes": [
    {
    "id": 1
    },
    {
    "id": 2
    },
    {
    "id": 3
    }
    ],
    "edges": [
    {
    "source": 1,
    "target": 2
    },
    {
    "source": 1,
    "target": 3,
    }
    ]
    };

    var data =
    {
    "nodes":
    [
    {"id":2,"caption":"о-в Нави"},
    {"id":5,"caption":"Большая земля"},
    {"id":6,"caption":"о-в Невезения (старт)"},
    {"id":7,"caption":"край Светы"},
    {"id":8,"caption":"о-в Надежды"}
    ],
    "edges":
    [
    {"source":2,"target":5},{"source":5,"target":2},{"source":5,"target":6},{"source":6,"target":2},{"source":6,"target":5},{"source":6,"target":8},{"source":7,"target":6},{"source":7,"target":8},{"source":8,"target":7}
    ]
    };

    {{--$.getJSON('/api/geo/locations', function(data) {--}}


    var config = {
    dataSource: data,
    forceLocked: true,
    directedEdges: false,
    edgeStyle: {
    "all": {
    "width": 5
    }
    },
    nodeStyle: {
    "all": {
    "width": 5,
    "radius": 8,
    }
    },
    fixNodes: true,
    nodeCaption: "caption",
    directedEdges: true,
    edgeCaption: "relatedness",
    nodeCaptionsOnByDefault: true,
    graphHeight: function(){ return 300; },
    graphWidth: function(){ return 300; },
    linkDistance: function(){ return 170; },
    nodeTypes: {"node_type":[ "Maintainer",
    "Contributor"]}
    };

    alchemy = new Alchemy(config);
    {{--});--}}

    //dataSource: 'data/contrib.json',


    //    alchemy.begin({
    //      "dataSource": some_data
    //    });



    //    </script>

@endsection