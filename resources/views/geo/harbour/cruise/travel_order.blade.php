@extends('geo._layout')

@section('title', 'Sea -> Travel Port')

@section('center')

    Можете заказать, что вам привезти из дальних стран
    <p>Можно заказать привезти оттуда разных ресов
    <p></p>
    {{ link_to_route('sea_travels_page', 'Назад к трэвелам\караванам', []) }}
    <p></p>

    {!! Form::open(['route' => 'sea_create_order_action', 'class' => 'form-signup']) !!}
    <h2 class="form-signup-heading">Данные по заказу</h2>
    <div class="form-group">
        {!! Form::label('resource_code', 'трэвел на ресурс: ' . $travel->resource_code, []) !!}
    </div>
    {!! Form::label('destination', $travel->destination, []) !!}
    {!! Form::hidden('travel_id', $travel->id, ['id' =>  '']) !!}

    <p></p>
    {!! Form::label('minutes', 'Таймер в минутах', []) !!}
    {!! Form::text('time', '5', ['id' =>  '', 'placeholder' =>  '', 'class' => 'form-control', 'type' => 'number', 'autofocus', 'required']) !!}
    <br>
    {!! Form::submit('Сделать заказ', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

@endsection



