@extends('drive.raid.layout')


@section('right_column')

    @parent

    <p></p>

    {!! Form::open(['route' => 'drive_robbery_abort_action', 'class' => '']) !!}
    {!! Form::submit('Прервать разбой', array('class' => 'btn btn-info')) !!}
    {!! Form::close() !!}

@endsection