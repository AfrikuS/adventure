@extends('layouts.app')

@section('title', 'Boss Page')

@section('head')
    @parent
@endsection

@section('center')

    Вы пришли на площадь Драки
    <p>
    @if(count($bosses) > 0)
        @foreach($bosses as $boss)
        {!! Form::open(['route' => 'boss_join_action', 'class' => 'form-inline']) !!}
            ID BOSS : {{ $boss->id }}
            {!! Form::hidden('boss_id', $boss->id, ['id' =>  'boss_'.$boss->id]) !!}
            {!! Form::submit('Включиться в бой', array('class' => 'btn')) !!}
            Уже дерутся: {{ $boss->count }}
        {!! Form::close() !!}
        @endforeach
    @else
    На боссов пока никто не напал, но всегда можно сать первым
    @endif

    <p></p>
    {!! Form::open(['route' => 'boss_create_action', 'class' => 'form-inline']) !!}
    {!! Form::submit('Начать драку', array('class' => 'btn')) !!}
    {!! Form::close() !!}

@endsection
