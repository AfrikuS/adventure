@extends('work.order.show.layout')



@section('completed')

    <p></p>
    <B>Вознаграждение: {{ $order->price }}</B>
    <p></p>
    <p></p>

    Заказ выполнен. Получить награду.
    <p></p>
    <p></p>

    {!! Form::open(['route' => 'work_order_cancel_apply_skill_action', 'class' => 'form-signup']) !!}
    {!! Form::hidden('order_id', $order->id, []) !!}
    {!! Form::submit('Cancel \'apply skill\'', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}


@endsection