@extends('drive.raid.layout')

@section('title', 'Raid - Search Victims')


@section('center')

    <h4>Тачка сломалась</h4>

    <br>
    <p></p>
    Выход один - катиться в гараж.
    <p></p>
    <p></p>
    {!! Form::open(['route' => 'drive_raid_finish_action', 'class' => '']) !!}
    {!! Form::submit('Закончить рейд', array('class' => 'btn btn-danger')) !!}
    {!! Form::close() !!}


@endsection
    