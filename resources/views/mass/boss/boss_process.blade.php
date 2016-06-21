@extends('layouts.app')

@section('title', 'Boss Process')

@section('head')
    @parent
@endsection

@section('center')

    <div>
        <div>
            Вы деретесь с Боссом
            <p>
            <div class="timer" data-seconds-left={{ $timer->duration_seconds }}></div>

            <p>Нападающие
            <ul>
                @foreach($workers as  $worker)
                    <li>{{ $worker->id }} :=> {{ $worker->name }}</li>
                @endforeach
            </ul>


            <P><P>
            {!! Form::open(['route' => 'boss_kick_action', 'class' => 'form-inline', 'id' => 'boss_kick']) !!}

                {!! Form::hidden('boss_id', $boss->id, []) !!}
                {!! Form::hidden('user_id', Auth::user()->id, []) !!}
                {!! Form::submit('Ударить', array('class' => 'btn')) !!}

            {!! Form::close() !!}
            <p></p>
            {{--<form id="kick_node">--}}
                <button id="kick_button">Ударить Node</button>
            {{--</form>--}}

            <p>
            Ударов нанесено: <div id="kicks">{{ $boss->kicks }}</div>
            <p></p>

            <ul id="kicks_list">
                <li>Kick info</li>
            </ul>


            {{--<p>--}}
            {{--<ul id="messages"></ul>#}--}}
            {{--{#<form action="" id="send_message">#}--}}
                {{--<input type="text" autocomplete="off" placeholder="ggdf" ng-model="newmessage"/>--}}
                {{--{#<input type="submit" value="Send" />#}--}}
                {{--<button ng-click="addMessage()">Add message</button>--}}

            {{--{#</form>#}--}}
            {{--<ul>--}}
                {{--<li ng-repeat="message in messages">{[{ message }]}</li>--}}
            {{--</ul>--}}
        </div>

        <p><p>

        {{--<div>--}}
            {{--<p>--}}
            {{--Email:<input type="text" ng-model="newcontact"/><br>--}}
            {{--<button ng-click="addMessage()">Add</button>--}}
            {{--<ul>--}}
                {{--<li ng-repeat="todo in todos">--}}
                    {{--{[{ todo.name }]}--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</div>--}}
    </div>


@endsection

@section('scripts')
    <script type="text/javascript" src="http://localhost:3000/socket.io/socket.io.js"></script>

    <script type="text/javascript">

       var socket = io('http://localhost:3000');

       socket.on('connect', function () {
           socket.emit('room', 'room_' + {{ $boss->id }});
       });

       <?php $user_id = Auth::user()->id; ?>
       <?php $user_name = Auth::user()->name; ?>

       $('#kick_button').click(function() {
           var kickData = {
               boss_id: {{ $boss->id }},
               user_id: {{ $user_id }},
               user_name: '{{ $user_name }}'
           };
           console.log(kickData);
           socket.emit('kick', kickData);

           return false;
       });

        socket.on('kick_answer', function (data) {
//            console.log('Всего ударов: ' + data.kicksCount + '. Ударил ' + data.lastKickAuthor);
            $('#kicks_list').append('<li>' + data.lastKickAuthor  + ' ударил</li>');
            $('#kicks').html(data.kicksCount);
        });

    </script>

@endsection
