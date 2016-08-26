@extends('employment._layout')

@section('title', 'Employment - School - Classroom')
@section('head')
    @parent



@endsection

@section('center')

    Мозаика знаний-умений
    <p></p>

    {{ $mosaic }}
    <p></p>
    <p></p>

    Прокачаться здесь можно только до 3 левела

    {!! Form::open(['route' => 'employment_school_learn_action']) !!}
    {!! Form::hidden('lore_id', $lore->id) !!}
    {!! Form::submit('Start learn process', array('class' => 'btn btn-warning')) !!}
    {!! Form::close() !!}





@endsection
