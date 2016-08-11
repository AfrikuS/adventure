@extends('railway.train._layout')

@section('title', 'Railway - Train Meeting')
@section('head')
    @parent
@endsection

@section('center')

    <h3>Транзитный поезд</h3>

    {{ $meeting->conductor->name }}
    <p></p>
    <p></p>
    Настроение у проводника: <b>{{ $meeting->mood }}</b>
    <p></p>
    <p></p>
    <p></p>
    <p></p>


    @if ($meeting->mood > 0)

        @yield('regular_bribe')

        @yield('thanks')

        @yield('rare_thing')

    @else

        @yield('enough')

    @endif



    <p></p>

    Смотрящий проводник\кондуктор полностью доволен. Карман закрылся
    <p></p>
    <p></p>
    {!! Form::open(['route' => 'railway_station_drain_oil_action', 'class' => '']) !!}
    {{--{!! Form::hidden('train_id', $train->id) !!}--}}
    {!! Form::text('amount', 10) !!}
    {!! Form::text('price', 6) !!}
    {!! Form::submit('Слить нефть', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}
    <p></p>
    <p></p>
    {!! Form::open(['route' => 'railway_station_drain_petrol_action', 'class' => '']) !!}
    {{--{!! Form::hidden('train_id', $train->id) !!}--}}
    {!! Form::text('amount', 10) !!}
    {!! Form::text('price', 6) !!}
    {!! Form::submit('Слить бензин', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

    <p></p>
    <p></p>


    {{--{!! Form::open(['route' => 'railway_station_drain_petrol_action', 'class' => '']) !!}--}}
    {{--{!! Form::submit('Подсоединить шланг к цистерне', array('class' => 'btn btn-primary')) !!}--}}
    {{--{!! Form::close() !!}--}}






@endsection