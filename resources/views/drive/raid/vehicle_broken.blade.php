@extends('drive.raid._layout')

@section('title', 'Raid - Broken Vehicle')


@section('center')

    <h4>Тачка сломалась</h4>

    <br>
    <p></p>
    Выход один - катиться в гараж.
    <p></p>
    <p></p>
    {!! Form::open(['route' => 'drive_workroom_page', 'class' => '']) !!}
    {!! Form::submit('Закончить рейд', array('class' => 'btn btn-danger')) !!}
    {!! Form::close() !!}


@endsection
    