@extends('drive.drive_layout')


@section('right_column')

    @parent

    <p></p>
    <b>{{ $raid->status }}</b>
    <p></p>
    <b>Вы награбили: {{ $raid->reward }}</b>
    <p></p>

    {!! Form::open(['route' => 'drive_raid_finish_action', 'class' => '']) !!}
    {!! Form::submit('Закончить рейд', array('class' => 'btn btn-danger')) !!}
    {!! Form::close() !!}

@endsection