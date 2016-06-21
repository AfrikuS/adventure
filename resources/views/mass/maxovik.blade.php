@extends('layouts.app')

@section('title', 'Maxovik Page')
@section('head')
    @parent
    <script src="{{ asset('js/new_timer.js') }}"></script>

@endsection

@section('center')

    Maxovik. Для игры нужно 2 челика
    <p></p>

    <p><div class="mydiv">
        <button class="btn-large btn-lg btn-block" id="mybutton" disabled>Another button</button>
    </div><p>

    <p></p>
    <div class="timer">
        <span class="hour">00</span>:<span class="minute">00</span>:<span class="second">00</span>
    </div>
    <div class="control">
        <button onClick="timer.start(1000)">Start</button>
        <button onClick="timer.stop()">Stop</button>
        <button onClick="timer.reset(60)">Reset</button>
        <button onClick="timer.mode(1)">Count up</button>
        <button onClick="timer.mode(0)">Count down</button>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="http://localhost:3001/socket.io/socket.io.js"></script>

    <script type="text/javascript">
        var socket = io('http://localhost:3001');
        var room = "abc1236";

        socket.on('connect', function () {
            socket.emit('room', room);
        });


        socket.on('show button', function(message){
            console.log(message);
            $('#mybutton').attr("disabled", false);
        });

        socket.on('hide button', function(message){
            console.log(message);
//            $('#mybutton').remove();
            $('#mybutton').attr("disabled", true);
        });

        socket.on('info', function(message){
            console.log(message);
            timer.reset(1000)
        });

        socket.on('winner', function(message){
            alert('you are winner');
        });

        $('#mybutton').click(function() {
            socket.emit('push', {});
            $('#mybutton').attr("disabled", true);
        });

        // ----------------------------------------------------



    </script>

@endsection



