@extends('drive.robbery.layout')

@section('title', 'Robbery - Gates Far')

@section('center')

    Вдали вы видите большие ворота и высокий забор.
    <p></p>
    Варианты:
    <p></p>
    <h3>Ворота вдали</h3>
    <p></p>

    {!! Form::open(['route' => 'drive_robbery_driveto_gates_action', 'class' => '']) !!}
    {!! Form::submit('Приблизиться', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

    <p></p>

    {!! Form::open(['route' => 'drive_robbery_view_gates_action', 'class' => '']) !!}
    {!! Form::submit('Разглядеть получше', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}
    <p></p>

    {{--{!! Form::open(['route' => 'drive_robbery_search_action', 'class' => '']) !!}--}}
    {{--{!! Form::submit('Проехать мимо', array('class' => 'btn btn-primary')) !!}--}}
    {{--{!! Form::close() !!}--}}



@endsection
    