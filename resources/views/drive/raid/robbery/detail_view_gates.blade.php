@extends('drive.raid.robbery._layout')

@section('title', 'Robbery - Gates Far')

@section('center')

    Вы напрягли свои органы зрения и смогли увидеть гораздо больше
    <p></p>
    Варианты:
    <p></p>
    <p></p>
    <h3>Подробный обзор</h3>
    <p></p>

    {!! Form::open(['route' => 'drive_robbery_driveto_gates_action', 'class' => '']) !!}
    {!! Form::submit('Приблизиться', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

    {{--<p></p>--}}

    {{--{!! Form::open(['route' => 'drive_robbery_view_gates_action', 'class' => '']) !!}--}}
    {{--{!! Form::hidden('victim_id', $victim->id) !!}--}}
    {{--{!! Form::submit('Разглядеть получше', array('class' => 'btn btn-primary')) !!}--}}
    {{--{!! Form::close() !!}--}}
    {{--<p></p>--}}

    {{--{!! Form::open(['route' => 'drive_robbery_search_action', 'class' => '']) !!}--}}
    {{--{!! Form::submit('Проехать мимо', array('class' => 'btn btn-primary')) !!}--}}
    {{--{!! Form::close() !!}--}}



@endsection
    