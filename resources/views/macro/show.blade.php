@extends('macro.layout')

@section('title', 'Process Buildings Page')
@section('head')
    @parent
@endsection

@section('center')

    @if($building->hasConcrete())
        Здание оборудовано под <b>{{ $building->concrete->title }}</b>

        {!! Form::open(['route' => 'building_smith_work_action', 'class' => '']) !!}
        <input type="range" name="count" min="0" max="{{ $resources->free_people }}" step="5" value="0">
        <p></p>
        {!! Form::label('title', 'Направить людей работать в кузнице, делать инструменты', ['class' => '']) !!}
        <p></p>
        {!! Form::label('', 'Часов работать', ['class' => '']) !!}
        {!! Form::text('time', '8', ['id' =>  '', 'placeholder' =>  'time', 'class' => 'form-control', 'type' => 'number', 'autofocus', 'required']) !!}
        <p></p>
        {!! Form::submit('Начать работу', array('class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}
        <p></p>

    @else
        Здание необорудовано, свободно
    @endif
@endsection

