@extends('drive.robbery.layout')

@section('title', 'Robbery - Warehouse Result')

@section('center')

    Вы въехали в <b>ресурс. склад</b>. Осмотревшись по сторонам вы нашли ___ кг голды,
    и пара галлонов нефти
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
    {!! Form::open(['route' => 'drive_raid_finish_action', 'class' => '']) !!}
    {!! Form::submit('Закончить рейд', array('class' => 'btn btn-danger')) !!}
    {!! Form::close() !!}


@endsection