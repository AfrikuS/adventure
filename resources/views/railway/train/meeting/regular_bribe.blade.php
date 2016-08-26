@extends('railway.train.meeting._layout')


@section('regular_bribe')


    <p></p>
    {!! Form::open(['route' => 'railway_conductor_take_bribe_action', 'class' => '']) !!}
    {!! Form::hidden('conductor_id', $meeting->conductor_id) !!}
    {!! Form::submit('1. Дать на лапу \ Огорчить', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}
    <p></p>
    <p></p>
    <p></p>

    <p></p>
    {!! Form::open(['route' => 'railway_conductor_take_thanks_action', 'class' => '']) !!}
    {!! Form::hidden('conductor_id', $meeting->conductor_id) !!}
    {!! Form::submit('2. Отблагодарить пинком в живот / Поднять настроение', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}
    <p></p>

    <p></p>
    {!! Form::open(['route' => 'railway_conductor_take_remains_action', 'class' => '']) !!}
    {!! Form::hidden('conductor_id', $meeting->conductor_id) !!}
    {!! Form::submit('3. Босяцкий подгон \ Расстроить', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}
    <p></p>
    <p></p>

@endsection

