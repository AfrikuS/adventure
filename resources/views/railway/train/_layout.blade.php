@extends('railway._layout')


@section('right_column')

    @parent

    <p></p>
    <p></p>

    Время до отхода поезда
    <p></p>
    <p></p>

    <div class="timer" data-seconds-left={{ $meeting->duration_seconds }}></div>

    <p></p>
    <p></p>
    {!! Form::open(['route' => 'railway_depart_train_action', 'class' => 'form-signup']) !!}
    {!! Form::submit('Поезд отправляется', array('class' => 'btn btn-danger')) !!}
    {!! Form::close() !!}

@endsection