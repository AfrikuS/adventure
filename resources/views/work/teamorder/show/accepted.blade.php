@extends('work.teamorder.show.layout')

@section('accepted')

    {!! Form::open(['route' => 'work_teamorder_estimate_action', 'class' => 'form-signup']) !!}
    {!! Form::hidden('order_id', $order->id, []) !!}
    {!! Form::submit('Оценить работу', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

@endsection



