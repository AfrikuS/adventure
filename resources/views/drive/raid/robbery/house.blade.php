@extends('drive.raid.robbery._layout')

@section('title', 'Robbery - House Result')

@section('center')

    Вы въехали в <b>дом</b>. Осмотревшись по сторонам вы нашли ___ кг годы, и пара галлонов нефти
    <p></p>
    <p></p>
    <p></p>
    <p></p>

    {!! Form::open(['route' => 'drive_robbery_finish_action', 'class' => '']) !!}
    {!! Form::submit('Вернуться в поле', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}
    <p></p>
    <p></p>
    <p></p>


@endsection