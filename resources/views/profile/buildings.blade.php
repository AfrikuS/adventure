@extends('profile._layout')

@section('title', 'Profile - Buildings Page')
@section('head')
    @parent
@endsection

@section('center')

    <p></p>
    <p></p>
    Ворота: <b>{{ $buildings->gatesLevel }}</b> ур.
    <p></p>
    <p></p>
    Забор: <b>{{ $buildings->fenceLevel }}</b> ур.
    <p></p>
    <p></p>
    Дверь в амбар: <b>{{ $buildings->ambarLevel }}</b> ур.
    <p></p>
    <p></p>
    Дверь в дом: <b>{{ $buildings->houseLevel }}</b> ур.
    <p></p>
    <p></p>
    Дверь в склад: <b>{{ $buildings->warehauseLevel }}</b> ур.

@endsection