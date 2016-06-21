@extends('layouts.app')

@section('head')
    @parent
    <script src="{{ asset('js/react-15.0.1/build/react.js')  }}"></script>
    <script src="{{ asset('js/react-15.0.1/build/react-dom.js')  }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.23/browser.min.js"></script>
    <script src="{{ asset('js/react-flip-move.js')  }}"></script>

@endsection


@section('left_column')
    <div class="panel panel-default">
        <div class="panel-heading">Links</div>
        <div class="panel-body">
            Отсюда можно перейти в:
            <p></p>
            <ul>
                @foreach ($locationsTo as $location)
                    <li>
                        <a href="/geo/location/{{ $location->id }}"> -> {{ $location->title }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection


@section('center')
    {{--<div class="container">--}}
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        Локация № {{ $currLocation->id }}
                        <p></p>
                        Локация title {{ $currLocation->title }}
                        <p></p>


                        <b>Форма добавления следующей локации</b>
                        <p>
                            {!! Form::open(array('url' => '/geo/bind_locations')) !!}
                            {!! Form::label('ID текущей локации') !!}
                            {!! Form::input('text', 'location_id', $currLocation->id) !!}
                            <br>
                            {!! Form::label('Выберете следующую локацию') !!}
                            {!! Form::select('next_location_id', $locationsSelect) !!}
                            <br>
                            {{--{!! Form::label('Зал проведения') !!}--}}
                            {{--{!! Form::select('hallId', $select_halls) !!}--}}
                            <br>
                        {{--{!! Form::text('data', null, ['id'=> 'datetimepicker4', 'class' => 'form-control']) !!}--}}

                        {!! Form::submit('Привязать') !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>


            {{--<div class="col-md-3">--}}
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading">{this.props.location.title}</div>--}}
                    {{--<div class="panel-body">--}}
                        {{--<span id="react_app"></span>--}}
                        {{--panel-body--}}
                        {{--<p></p>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}


        </div><!-- .row-->
    {{--</div>--}}
@endsection

@section('right_column')
    @parent

    <div class="panel panel-default">
        <div class="panel-heading">this.props.location_title2</div>
        <div class="panel-body">
            Отсюда можно перейти:
            <p></p>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="http://localhost:3002/socket.io/socket.io.js"></script>

    <script type="text/javascript" >
        var socket = io('http://localhost:3002');
        var roomNumber = '{{ $currLocation->id }}';
        var data = {
            user: {
                id: '{{ auth()->user()->id }}',
                name: '{{ auth()->user()->name }}'
            },
            location: {
                id: '{{ $currLocation->id }}',
                title: '{{ $currLocation->title }}'
            }
        };

        socket.on('connect', function () {
            console.log(data);
            socket.emit('room', data);
        });


        socket.on('info', function(data){
            console.log(data);
//            $("#list_1").append('<li>' + data  + '</li>');
        });


//        $('#mybutton').click(function() {
//            socket.emit('push', {});
//            $('#mybutton').attr("disabled", true);
//        });


    </script>

@endsection
