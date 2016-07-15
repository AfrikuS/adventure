@extends('drive.raid._layout')

@section('title', 'Raid - Search Victims')


@section('center')

    <h4>Результаты поиска.</h4>

    <br>
    <p></p>
    Вы поездили по округе, но никого не нашли:
    <p></p>
    <p></p>
    {!! Form::open(['route' => 'drive_raid_search_victim_action', 'class' => '']) !!}
    {!! Form::hidden('victim_id', $victim_id) !!}
    {!! Form::submit('Искать ещё', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}


    {{--{!! Form::open(['route' => 'drive_raid_to_pitstop_action', 'class' => '']) !!}--}}
    {{--{!! Form::submit('Заехать в Пит-Стоп', array('class' => 'btn btn-primary')) !!}--}}
    {{--{!! Form::close() !!}--}}
    <p></p>


@endsection
    