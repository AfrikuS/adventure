@extends('geo._layout')

@section('title', 'Geo - Dock Index')

@section('head')
    @parent

    {{--<link rel="stylesheet" href="{{ asset('js/alchemy-0.4.1/alchemy.css') }}">--}}

    {{--<script src="{{ asset('js/d3/d3.js') }}" charset="utf-8"></script>--}}
    {{--<script src="{{ asset('js/alchemy-0.4.1/scripts/vendor.js') }}"></script>--}}
    {{--<script src="{{ asset('js/alchemy-0.4.1/alchemy.js') }}"></script>--}}
@endsection


@section('center')


    <div class="row row-offcanvas">
        <div class="col-lg-12">
            {{--<div id="alchemy" class="alchemy"></div>--}}
            <p></p>
            <h4>Список локаций и путей между ними</h4>

            @include('_partials.geo.map')


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
    dataSource: '/api/geo/locations',
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


    //        alchemy.begin({
    //          "dataSource": some_data
    //    });



    //    </script>

@endsection