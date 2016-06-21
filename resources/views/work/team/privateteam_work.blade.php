@extends('layouts.app')

@section('title', 'Profile Page')
@section('head')
    @parent
@endsection

@section('center')

    <hr>
    <P><P><P><P>
        Блок по team_workers
    <P><P><P><P>

    <p><p><p>
        Подтвердить Готовность к работе
    {!! Form::open(['route' => 'work_ready_to_teamwork_action', 'class' => '']) !!}
    <p>
    {!! Form::hidden('privateteam_id', $privateteam->id, ['id' =>  '']) !!}
    <p>
        {!! Form::submit('Ready to work', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}

        Готовы к работе:
    <ul>
        @foreach($workers as $worker)
            <li><b>{{ $worker->user->name }}</b> - {{ $worker->status }}</li>
        @endforeach
    </ul>

    <p></p>
    {{--<button id="kick_button">Ready</button>--}}

    {{--<p>Messages</p>--}}
    {{--<ul id="kicks_list">--}}
    {{--</ul>--}}

@endsection

@section('scripts')
    {{--<script type="text/javascript" src="http://localhost:3003/socket.io/socket.io.js"></script>--}}

    {{--<script type="text/javascript">--}}

    {{--var socket = io('http://localhost:3003');--}}

    {{--socket.on('connect', function () {--}}
    {{--socket.emit('room', 'room_' + {{ $boss->id }});--}}
    {{--socket.emit('room', 'room_1');--}}
    {{--});--}}

    {{--$('#kick_button').click(function() {--}}
    {{--var kickData = {--}}
    {{--privateteam_id: 'privateteam_number',--}}
    {{--user_id: {{ Auth::user()->id }},--}}
    {{--user_name: '{{ Auth::user()->name }}'--}}
    {{--};--}}
    {{--console.log(kickData);--}}
    {{--socket.emit('worker ready', kickData);--}}

    {{--return false;--}}
    {{--});--}}

    {{--//                socket.on('kick_answer', function (data) {--}}
    {{--////            console.log('Всего ударов: ' + data.kicksCount + '. Ударил ' + data.lastKickAuthor);--}}
    {{--//                    $('#kicks_list').append('<li>' + data.lastKickAuthor  + ' ударил</li>');--}}
    {{--//                    $('#kicks').html(data.kicksCount);--}}
    {{--//                });--}}

    {{--</script>--}}

@endsection
