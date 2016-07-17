@extends('profile._layout')

@section('title', 'Profile - Buildings Page')
@section('head')
    @parent
@endsection

@section('center')

    <p></p>
    <p></p>
    Ворота: <b>{{ $buildings->gates_level }}</b> ур.
    <p></p>
    <p></p>
    Забор: <b>{{ $buildings->fence_level }}</b> ур.
    <p></p>
    <p></p>
    Дверь в амбар: <b>{{ $buildings->door_ambar_level }}</b> ур.
    <p></p>
    <p></p>
    Дверь в дом: <b>{{ $buildings->door_house_level }}</b> ур.
    <p></p>
    <p></p>
    Дверь в склад: <b>{{ $buildings->door_resource_warehause_level }}</b> ур.

@endsection