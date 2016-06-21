@extends('layouts.app')

@section('title', 'Profile Page')
@section('head')
    @parent
@endsection

@section('center')

    Создать PrivateTeam for collective works (teamwork)
    <p>
        Создавая свою команду, вы сможете брать более крупные заказы, выполняя к-ые
        вы будете получать больше опыта и более крупное вознаграждение
    <p>
        {!! Form::open(['route' => 'work_create_privateteam_action', 'class' => '']) !!}
        <br>
        {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    <p></p>

@endsection

