@extends('railway.train.meeting._layout')


@section('thanks')


    <p></p>
    {!! Form::open(['route' => 'railway_conductor_take_thanks_action', 'class' => '']) !!}
    {!! Form::hidden('conductor_id', $meeting->conductor_id) !!}
    {!! Form::submit('2. Отблагодарить / Поднять настроение', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}
    <p></p>


@endsection
