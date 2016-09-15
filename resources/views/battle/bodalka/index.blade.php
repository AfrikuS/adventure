@extends('layouts.app')

@section('title', 'Bodalka Page')
@section('head')
    @parent
@endsection

@section('center')


        {!! Form::open(['route' => 'bodalka_start_action', 'class' => 'form-signup']) !!}
        {!! Form::submit('Бодаться (таймаут 5 минут)', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
        {!! Form::close() !!}

@endsection
