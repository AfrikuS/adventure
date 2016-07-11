@extends('layouts.app')

@section('title', 'Profile Page')
@section('head')
    @parent
@endsection

@section('left_column')
    <ul>
        <li>Profile LINKS</li>
        <li><a href="/work">Виды работ</a></li>
        <li><a href="/work/mine">Работы под добыче ресурсов</a></li>
    </ul>

@endsection

@section('center')

    Требования к созданию группы, описание бонусов, правил работы в таких группах
    <p>

    {!! Form::open(['route' => 'work_create_privateteam_action', 'class' => '']) !!}
    {!! Form::label('title', 'Создать группу для коллективной добычи шаров', ['class' => '']) !!}
    <br>
    {!! Form::submit('Создать', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
    <p></p>

@endsection

