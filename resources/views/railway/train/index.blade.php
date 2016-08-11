@extends('railway.train._layout')

@section('title', 'Railway - Transit Train')
@section('head')
    @parent
@endsection

@section('center')

    <h3>Транзитный поезд</h3>

    <p></p>
    <p></p>
    <p></p>
    {{ link_to_route('railway_train_conductor_page', 'Подойти к проводнику') }}
    <p></p>
    <p></p>

    Подойти к челнокам
    <p></p>
    <p></p>




@endsection