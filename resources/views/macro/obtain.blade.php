@extends('macro.layout')

@section('title', 'Macro Obtain Page')
@section('head')
    @parent
@endsection

@section('center')
    <p></p>

    Форма.
    Отправить на добычу мяса\молока
    ползунок от 0 - 100 (предел размеров леса)

    Кнопка отправить

    Отправить на добычу дерева
    ползунок от 0 - 100
    Кнопка отправить

    <p></p>
    {!! Form::open(['route' => 'politic_learn_profession', 'class' => '']) !!}
    <input type="range" name="count" min="0" max="{{ $resources->free_people }}" step="5" value="0">
    <p></p>
    <p></p>
    <select class="form-control" id="empl_kind" name="kind">
        <option value="obtain_food">Охотиться \ Ловить рыбу</option>
        <option value="obtain_tree">Рубить деревья</option>
        <option value="obtain_water">Пойти за водой</option>
    </select>
    <p></p>
    {!! Form::text('time', '8', ['id' =>  '', 'placeholder' =>  'time', 'class' => 'form-control', 'type' => 'number', 'autofocus', 'required']) !!}
    <p></p>
    {!! Form::submit('Направить людей собирать еду', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}
    <p></p>


    {{--{!! Form::hidden('user_id', $attack->user_id, ['id' =>  '']) !!}--}}

    {!! Form::open(['route' => 'politic_learn_profession', 'class' => '']) !!}
    Оставить людей обучаться ремеслу у того, кто владеет им
    <select class="form-control" id="empl_kind" name="kind">
        <option value="smith_kind">Изучать кузнечное ремесло (без кузницы)</option>
        <option value="lesorub_kind">Учиться рубить деревья(без дерева)</option>
        <option value="hunter_kind">Охотное ремесло(без зверя)</option>
        <option value="hunter_kind">Во время работы у некоторых появляется навык в деле</option>
    </select>
    {!! Form::submit('Учить', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

    <p></p>

@endsection


