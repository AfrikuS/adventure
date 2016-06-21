@extends('layouts.app')

@section('title', 'Boss End')

@section('head')
    @parent
@endsection

@section('center')

    Босс повержен
    <p>
    <p>В команде трудились:
    <BR>
    @foreach ($workers as $user)
        {{ $user->id }} :=> {{ $user->name }}
        <p>
    @endforeach



@endsection