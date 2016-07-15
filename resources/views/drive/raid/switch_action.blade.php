@extends('drive.raid.layout')

@section('title', 'Raid - Switch Action')


@section('center')

    <h4>Вы на развилке. Решайте что будете делать.</h4>

    <br>
    <p></p>
    <p></p>
    {!! Form::open(['route' => 'drive_raid_search_victim_action', 'class' => '']) !!}
    {!! Form::submit('Искать жертву', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}
    <p></p>

    {{--'to_robbery' --}}
    {{--'complete_robbery--}}

    {{--{!! Form::open(['route' => 'drive_raid_to_pitstop_action', 'class' => '']) !!}--}}
    {{--{!! Form::submit('Заехать в Пит-Стоп', array('class' => 'btn btn-primary')) !!}--}}
    {{--{!! Form::close() !!}--}}
    <p></p>

@endsection
    