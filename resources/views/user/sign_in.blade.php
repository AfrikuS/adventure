@extends('layouts.not_auth')

@section('title', 'Sign in Page')
@section('head')
    @parent
@endsection

@section('content')

    {!! Form::open(['route' => 'sign_in_action', 'class' => 'form-inline']) !!}
    {!! Form::text('name', '', ['id' =>  'q', 'placeholder' =>  'login', 'class' => 'input-small']) !!}
    {!! Form::submit('Sign in', array('class' => 'btn')) !!}
    {!! Form::close() !!}

@endsection

