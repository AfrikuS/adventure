@extends('drive.raid._layout')

@section('title', 'Raid - Search Victims')


@section('center')

    <h4>Результаты поиска.</h4>

    <br>
    <p></p>
    Вы поездили по округе, у вас на примете несколько человек:
    <p></p>
    {!! Form::open(['route' => 'drive_raid_robbery_start_action', 'class' => '']) !!}
    {!! Form::hidden('victim_id', $victim_id) !!}
    {!! Form::submit('Наехать', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}
    <p></p>
    {!! Form::open(['route' => 'drive_raid_search_victim_action', 'class' => '']) !!}
    {!! Form::submit('Искать ещё', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

    {{--'to_robbery' --}}
    {{--'complete_robbery--}}

    {{--{!! Form::open(['route' => 'drive_raid_to_pitstop_action', 'class' => '']) !!}--}}
    {{--{!! Form::submit('Заехать в Пит-Стоп', array('class' => 'btn btn-primary')) !!}--}}
    {{--{!! Form::close() !!}--}}
    <p></p>


@endsection
    