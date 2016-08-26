@extends('railway.train.meeting._layout')


@section('rare_thing')


    <p></p>
    {!! Form::open(['route' => 'railway_conductor_take_remains_action', 'class' => '']) !!}
    {!! Form::hidden('conductor_id', $meeting->conductor_id) !!}
    {!! Form::submit('3. Босяцкий подгон', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}
    <p></p>
    <p></p>

@endsection
