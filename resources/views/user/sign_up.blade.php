@extends('layouts.not_auth')

@section('title', 'Sign Up Page')
@section('head')
    @parent
@endsection

@section('content')

    {!! Form::open(['route' => 'sign_in_action', 'class' => 'form-signup']) !!}
        <h2 class="form-signup-heading">Please sign up</h2>
    {{--{!! Form::label('asa) !!}--}}
        <label for="inputUsername" class="sr-only">Input username</label>
        {{--<input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" required autofocus>--}}
        {!! Form::text('name', '', ['id' =>  'inputUsername', 'placeholder' =>  'Username', 'class' => 'form-control']) !!}
        <label for="inputPassword" class="sr-only">Password</label>
        {!! Form::password('password', ['id' =>  'inputPassword', 'placeholder' => 'Password', 'class' => 'form-control', 'value' => '123']) !!}
        {{--<input type="password" id="" class="form-control" placeholder="" >--}}
        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        {!! Form::submit('Sign up', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
    {!! Form::close() !!}


    {{--<form class="form-signup" action="/register" method="POST">--}}

    {{--@if message is defined %}--}}
        {{--<div class="alert alert-warning" role="alert">{{ message }}</div>--}}
    {{--@endif %}--}}


@endsection

