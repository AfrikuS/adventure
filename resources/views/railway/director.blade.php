@extends('railway._layout')

@section('title', 'Railway - Director')
@section('head')
    @parent
@endsection

@section('center')

    <p></p>
    @if ($license != null)
        Срок дейcтвия лицензии
        <p></p>
        <p></p>
        <div class="timer" data-seconds-left={{ $license->duration_seconds }}></div>
        <p></p>
        <p></p>
        {!! Form::open(['route' => 'railway_buy_license_action', 'class' => '']) !!}
        {!! Form::submit('Продлить лицензию', array('class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}
    @else
        {!! Form::open(['route' => 'railway_buy_license_action', 'class' => '']) !!}
        {!! Form::submit('Купить лицензию', array('class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}
    @endif

    <p></p>
    <p></p>




@endsection