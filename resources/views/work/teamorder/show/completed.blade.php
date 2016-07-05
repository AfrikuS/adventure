@extends('work.teamorder.show.layout')



@section('completed')

    <B>Вознаграждение: {{ $order->price }}</B>
    <p></p>

    Заказ выполнен
    <p><p>
    {!! Form::open(['route' => 'work_teamorder_take_reward_action', 'class' => 'form-signup']) !!}
    {!! Form::hidden('order_id', $order->id, []) !!}
    {!! Form::submit('Получить награду', array('class' => 'btn btn-success')) !!}
    {!! Form::close() !!}

@endsection