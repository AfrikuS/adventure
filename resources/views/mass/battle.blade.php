@extends('layouts.app')

@section('title', 'Battle Page')
@section('head')
    @parent
@endsection

@section('center')

    <form id="bid" class="bid_form">
{{--    {!! Form::open(['action' => ['BattleController@form'], 'class' => '']) !!}--}}
        {{ Form::radio('choice', '1', 0, ['class' => 'field', 'id' => 'radio_1']) }}
        <label>First</label>
        {{ Form::radio('choice', '2', 0, ['class' => 'field']) }}2
        <label>Second</label>
        {{ Form::radio('choice', '3', 0, ['class' => 'field']) }}3
        <label>Third</label>

        {{--<input type="submit" id="doBid" value="Сделать ставку">--}}
        {!! Form::submit('Сделать ставку', array('id'=> '', 'class' => 'btn btn-primary', 'name' => 'bid_submit')) !!}
    {!! Form::close() !!}

        <p></p>
        <ul>
            <li>Встреча со зверем</li>
            <li>Наши возможные действия</li>
            <li>Убежать, начать схватку, спрятаться</li>
            <li>Схватка неизбежна</li>
            <li>Страница с боем, наши варианты</li>
            <li>Пошаговый бой</li>
            <li>НАнести удар в голлову, выстрелить</li>
        </ul>

@endsection

@section('scripts')
    <script type="text/javascript" src="http://localhost:3003/socket.io/socket.io.js"></script>

    <script type="text/javascript">
        var socket = io('http://localhost:3003');
        var counter = 4;

        socket.on('connect', function () {
            socket.emit('init new user');
            console.log('init new user');
        });

        socket.on('new card', function (data) { // card_id, card_title

            var choice = "<label>" + data.card_title + "</label>\
                <input class='field' name='choice' type='radio' value='${data.card_id}'>";


//            replaceRadioChoice (radio, { value: data.card_id, label: data.card_title });
            $('.bid_form').prepend(choice);

        });

        $('.bid_form').submit(function() {
            console.log(this);
            var radio = $('input[name="choice"]:checked', '.bid_form');
            console.log(radio.val());

//            radio.attr('value', 989);

//            radio.next().text('default');
//            alert(radio.val());
//            var lotId = $('#lot_id').val();
//            var lotId = $(this).find(".lot_id").val();

            radio.remove();
            radio.next().remove();
            socket.emit('put card', {card_id: radio.val()});
    //            $(this).find("input[name=bid_submit]").attr("disabled", true);
    //            $('#doBid').attr("disabled", true);
            // do bid_button is disable while not recieved from server

            return false;
        });


        function replaceRadioChoice (radio, data) {
        var choice = '<label>New choice</label>\
                <input class="field" name="choice" type="radio" value="13">';

            radio.attr('value', data.value);
            radio.next().text(data.label);
        }

/*

//$('button[name^="but_"]').on('click', 'button', function(){
$('#buts').on('click', 'button', function(){
    console.log(this.name);
    var button_id = this.name.split("_")[1];
    console.log(button_id);
    $('#buts').prepend( '<button name="but_' + counter + '" >Open Website</button>');

    this.remove();
    counter++;
});
*/



    </script>

@endsection



