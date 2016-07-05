@extends('work.order.show.layout')


@section('stock_skills')

    <p></p><p></p><p></p>
    <B>Вид работ: {{ $order->kind_work_title }}</B>
    <p></p>
    <B>Вознаграждение: {{ $order->price }}</B>
    <p></p>

    Можно начинать работы.
    <p>
        Кнопка начать работы (указано время работ)
    <p>
    {!! Form::open(['route' => 'work_order_apply_skill_action', 'class' => 'form-signup']) !!}
    {!! Form::hidden('order_id', $order->id, []) !!}
    {!! Form::submit('Начать работу', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

@endsection