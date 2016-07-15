@extends('drive.robbery.layout')

@section('title', 'Robbery - Fence Near')

@section('center')

    Вы легко взломали ворота и въехали во двор, пробраться во внутренний двор мешает забор,
    <br>трещин и скрытых ходов не видно. Вы решаете ехать прямо напролом
    <p></p>
    Ваши действия
    <p></p>
    <p></p>
    <h3>Забор после ворот</h3>
    <p></p>

    {!! Form::open(['route' => 'drive_robbery_drivein_fence_action', 'class' => '']) !!}

    {{--@include('drive.robbery._specials')--}}

    {!! Form::submit('Въехать в забор', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}


@endsection
    